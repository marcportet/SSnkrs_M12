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
  const sql =
    "SELECT s.*, SUM(ss.stock) AS stock, GROUP_CONCAT(sz.size) AS sizes FROM sneakers s INNER JOIN sneaker_sizes ss ON s.id = ss.sneaker_id INNER JOIN sizes sz ON ss.size_id = sz.id GROUP BY s.id ORDER BY s.brand;";
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
    "SELECT s.*, SUM(ss.stock) AS stock, GROUP_CONCAT(sz.size) AS sizes FROM sneakers s INNER JOIN sneaker_sizes ss ON s.id = ss.sneaker_id INNER JOIN sizes sz ON ss.size_id = sz.id WHERE s.id = ? GROUP BY s.id";
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
  const { name, sizes, brand, price, stock, image } = req.body;

  const imageName = image.split('/').pop()

  cloudinary.uploader.upload(image,
    { public_id: imageName });

  // Insertar la sneaker en la tabla sneakers con la ruta de la imagen de Google Drive
  const sneakerSql =
    "INSERT INTO sneakers (name, brand, price, image) VALUES (?, ?, ?, ?);";
  db.query(sneakerSql, [name, brand, price, imageName], (err, result) => {
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

// Endpoint para modificar un sneaker por id
app.put("/api/sneakers/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { name, sizes, brand, price, stock, image } = req.body;

  const imageName = image.split('/').pop()

  cloudinary.uploader.upload(image,
    { public_id: imageName });

  // Actualizar la información de la sneaker en la tabla sneakers
  const sneakerSql =
    "UPDATE sneakers SET name = ?, brand = ?, price = ?, image = ? WHERE id = ?";
  db.query(
    sneakerSql,
    [name, brand, price, imageName, sneakerId],
    (err, result) => {
      if (err) {
        return res.status(400).json({ message: err.message });
      } else {
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
            return res
              .status(200)
              .json({ message: "Sneaker y tallas actualizados exitosamente" });
          }
        });
      }
    }
  );
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
        .status(200)
        .json({ message: "Sneaker y tallas actualizados exitosamente" });
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

