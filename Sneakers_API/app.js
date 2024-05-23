const express = require("express");
const db = require("./db");
const cors = require("cors");

const app = express();
const PORT = 3000;

const cloudinary = require('cloudinary').v2;

cloudinary.config({
  cloud_name: 'dfu47xomo',
  api_key: '499673422426478',
  api_secret: 'XKVcvpPM9sQfhr9DLJFaTZvaN5w'
});

app.use(cors());
app.use(express.json());
app.listen(PORT, () => {
  // Iniciar el servidor
  console.log(`Server inicializado en http://localhost:${PORT}`);
});

// Endpoint para obtener todos los sneakers
app.get("/api/sneakers", (req, res) => {
  let sql =
    "SELECT s.*, SUM(ss.stock) AS stock, GROUP_CONCAT(sz.size) AS sizes FROM sneakers s INNER JOIN sneaker_sizes ss ON s.id = ss.sneaker_id INNER JOIN sizes sz ON ss.size_id = sz.id";

  const type = req.query.type;
  const num = req.query.num;
  const columna = req.query.columna;
  const filtro = req.query.filtro;

  if (type) {
    switch (type) {
      case "like":
        if (filtro) {
          sql += " WHERE s." + columna + " LIKE '" + filtro + "'";
        }
        break;
      case "num":

        break;
      case "limit":
        sql += " GROUP BY s.id ORDER BY s.brand";
        sql += " LIMIT " + num;
        break;

      default:
        break;
    }
  }
  if (type != "limit" || !type) {
    sql += " GROUP BY s.id ORDER BY s.brand";
  }
  sql += ";";

  db.query(sql, (err, result) => {
    if (err) {
      res.status(500).json({ message: err.message });
    } else {
      res.json(result);
    }
  });
});


// Endpoint para obtener un sneaker por id
app.get("/api/sneakers/:id", (req, res) => {
  const sneakerId = req.params.id;
  const sql =
    "SELECT s.*, GROUP_CONCAT(ss.stock) AS stock, GROUP_CONCAT(sz.size) AS sizes FROM sneakers s INNER JOIN sneaker_sizes ss ON s.id = ss.sneaker_id INNER JOIN sizes sz ON ss.size_id = sz.id WHERE s.id = ? GROUP BY s.id";
  db.query(sql, sneakerId, (err, result) => {
    if (err) {
      res.status(500).json({ message: err.message });
    } else {
      if (result.affectedRows === 0) {
        return res
          .status(404)
          .json({
            message: "No se encontró el sneaker con el ID proporcionado",
          });
      } else {
        res.json(result);
      }
    }
  });
});

// Endpoint para crear un sneaker
app.post("/api/sneakers", async (req, res) => {
  const { name, brand, price, image, sizes, stock } = req.body;

  // Subir la imagen a Cloudinary y obtener la URL
  cloudinary.uploader.upload(image, async (error, result) => {
    if (error) {
      return res.status(500).json({ message: "Error al subir la imagen" });
    }

    const imageUrl = result.secure_url; // URL de la imagen en Cloudinary

    // Insertar la sneaker en la tabla sneakers con la URL de la imagen de Cloudinary
    const sneakerSql =
      "INSERT INTO sneakers (name, brand, price, image) VALUES (?, ?, ?, ?);";
    db.query(sneakerSql, [name, brand, price, imageUrl], (err, result) => {
      if (err) {
        return res.status(400).json({ message: err.message });
      } else {
        // Si no hay error, añadir tallas de la sneaker
        const sneakerId = result.insertId;
        const sneakerSizesSql =
          "INSERT INTO sneaker_sizes (sneaker_id, size_id, stock) VALUES (?, ?, ?)";
        for (let i = 0; i < sizes.length; i++) {
          db.query(
            sneakerSizesSql,
            [sneakerId, sizes[i], stock[i]],
            (err, result) => {
              if (err) {
                console.error("Error al insertar talla:", err);
              }
            }
          );
        }
        return res
          .status(201)
          .json({ message: "Sneaker creado exitosamente" });
      }
    });
  });
});

// Endpoint para modificar un sneaker por id
app.put("/api/sneakers/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { name, sizes, brand, price, stock, image } = req.body;

  // Subir la nueva imagen a Cloudinary y obtener la URL
  cloudinary.uploader.upload(image, async (error, result) => {
    if (error) {
      return res.status(500).json({ message: "Error al subir la imagen" + error });
    }

    const imageUrl = result.secure_url; // URL de la nueva imagen en Cloudinary

    // Actualizar la información de la sneaker en la tabla sneakers con la URL de la nueva imagen
    const sneakerSql =
      "UPDATE sneakers SET name = ?, brand = ?, price = ?, image = ? WHERE id = ?";
    db.query(
      sneakerSql,
      [name, brand, price, imageUrl, sneakerId],
      (err, result) => {
        if (err) {
          return res.status(400).json({ message: err.message });
        } else {
          if (sizes != undefined && stock != undefined) {
            // Eliminar las tallas asociadas existentes en la tabla sneaker_sizes
            const deleteSql = "DELETE FROM sneaker_sizes WHERE sneaker_id = ?";
            db.query(deleteSql, [sneakerId], (err, result) => {
              if (err) {
                console.error("Error al eliminar tallas:", err);
                return res
                  .status(500)
                  .json({ message: "Error interno del servidor" });
              } else {
                // Insertar las nuevas tallas asociadas en la tabla sneaker_sizes
                const sneakerSizesSql =
                  "INSERT INTO sneaker_sizes (sneaker_id, size_id, stock) VALUES (?, ?, ?)";
                for (let i = 0; i < sizes.length; i++) {
                  db.query(
                    sneakerSizesSql,
                    [sneakerId, sizes[i], stock[i]],
                    (err, result) => {
                      if (err) {
                        console.error("Error al insertar talla:", err);
                      }
                    }
                  );
                }

              }
            });
          }
          return res
            .status(200)
            .json({ message: "Sneaker y tallas actualizados exitosamente" });
        }
      }
    );
  });
});

// Endpoint para modificar las tallas de la sneaker por id
app.put("/api/sneakers_sizes/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { sizes, stock } = req.body;

  // Eliminar las tallas asociadas existentes en la tabla sneaker_sizes
  const deleteSql = "DELETE FROM sneaker_sizes WHERE sneaker_id = ?";
  db.query(deleteSql, [sneakerId], (err, result) => {
    if (err) {
      console.error("Error al eliminar tallas:", err);
      return res
        .status(500)
        .json({ message: "Error interno del servidor" });
    } else {
      // Insertar las nuevas tallas asociadas en la tabla sneaker_sizes
      const sneakerSizesSql =
        "INSERT INTO sneaker_sizes (sneaker_id, size_id, stock) VALUES (?, ?, ?)";
      for (let i = 0; i < sizes.length; i++) {
        if (stock[i] != 0) {
          db.query(
            sneakerSizesSql,
            [sneakerId, sizes[i], stock[i]],
            (err, result) => {
              if (err) {
                console.error("Error al insertar talla:", err);
              }
            }
          );
        }
      }
      return res
        .status(200)
        .json({ message: "Tallas de la sneaker actualizadas exitosamente" });
    }
  });
});

// Endpoint para eliminar un sneaker por su ID
app.delete('/api/sneakers/:id', async (req, res) => {
  const sneakerId = req.params.id;

  // Eliminar imagen de Cloudinary
  const sql = "SELECT image FROM sneakers WHERE id = ?;";
  db.query(sql, sneakerId, (err, result) => {
    if (err) {
      res.status(500).json({ message: err.message });
    } else {
      if (result.length > 0 && result[0].image) {
        const imageName = result[0].image;
        cloudinary.uploader.destroy(imageName, { invalidate: true });
      } else {
        res.status(404).json({ message: "No se encontró una imagen para el sneaker con el ID proporcionado" });
      }
    }
  });

  // Eliminar tallas de la sneaker en la tabla sneaker_sizes
  const deleteSizesSql = 'DELETE FROM sneaker_sizes WHERE sneaker_id = ?';
  db.query(deleteSizesSql, [sneakerId], (err, result) => {
    if (err) {
      return res.status(400).json({ message: err.message });
    } else {
      // Eliminar sneaker en la tabla sneakers
      const deleteSneakerSql = 'DELETE FROM sneakers WHERE id = ?';
      db.query(deleteSneakerSql, [sneakerId], (err, result) => {
        if (err) {
          return res.status(400).json({ message: err.message });
        } else {
          if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'No se encontró la sneaker con el ID proporcionado' });
          } else {
            return res.status(200).json({ message: 'Sneaker eliminado exitosamente' });
          }
        }
      });
    }
  });

});

// Reducir stock por id de sneaker
app.put("/api/sneakers_sizes/delstock/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { size } = req.body;

  // Reducir Talla
  const sneakerSizesSql =
    "UPDATE sneaker_sizes SET stock = (stock-1) WHERE sneaker_id = ? AND size_id = ?";
  db.query(
    sneakerSizesSql,
    [sneakerId, size],
    (err, result) => {
      if (err) {
        console.error("Error al reducir stock:", err);
      }
    }
  );
  return res
    .status(200)
    .json({ message: "Tallas de la sneaker actualizadas exitosamente" });
});

// Aumentar stock por id de sneaker
app.put("/api/sneakers_sizes/addstock/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { size, stock } = req.body;

  // Reducir Talla
  const sneakerSizesSql =
    "UPDATE sneaker_sizes SET stock = (stock+?) WHERE sneaker_id = ? AND size_id = ?";
  db.query(
    sneakerSizesSql,
    [stock, sneakerId, size],
    (err, result) => {
      if (err) {
        console.error("Error al agregar stock:", err);
      } else {
        if (result.affectedRows === 0) {
          const sneakerSizesSql =
            "INSERT INTO sneaker_sizes (sneaker_id, size_id, stock) VALUES (?, ?, ?)";
          db.query(
            sneakerSizesSql,
            [sneakerId, size, stock],
            (err, result) => {
              if (err) {
                console.error("Error al insertar talla:", err);
              }
            }
          )
        }
      }
    }
  );
  return res
    .status(200)
    .json({ message: "Tallas de la sneaker actualizadas exitosamente" });
});

// Endpoint para obtener las tallas
app.get("/api/sizes", (req, res) => {
  const sql =
    "SELECT * FROM `sizes`;";
  db.query(sql, (err, result) => {
    if (err) {
      res.status(500).json({ message: err.message });
    } else {
      if (result.affectedRows === 0) {
        return res
          .status(404)
          .json({
            message: "No se encontró el sneaker con el ID proporcionado",
          });
      } else {
        res.json(result);
      }
    }
  });
});
