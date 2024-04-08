const express = require("express");
const db = require("./db");
const fs = require("fs");
const path = require("path");

const app = express();
const PORT = 3000;

app.use(express.json());
app.listen(PORT, () => {
  // Iniciar el servidor
  console.log(`Server inicializado en http://localhost:${PORT}`);
});

// Ruta para obtener todos los sneakers
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

// Ruta para obtener un sneaker por id
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

// Ruta para crear un nuevo sneaker
app.post("/api/sneakers", (req, res) => {
  const { name, sizes, brand, price, stock, image } = req.body;

  // Extraer el nombre del archivo de la URL proporcionada
  const imageName = image.substring(image.lastIndexOf("/") + 1);

  // Definir la ruta de origen y destino de la imagen
  const sourcePath = "/home/marcp/Imágenes/" + imageName;
  const destinationPath = path.join(__dirname, "images", imageName);

  // Copiar el archivo a la carpeta images
  fs.copyFile(sourcePath, destinationPath, (err) => {
    if (err) {
      return res.status(500).json({ message: "Error al guardar la imagen" });
    } else {
      // Insertar la sneaker en la tabla sneakers
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
    }
  });
});

app.put("/api/sneakers/:id", (req, res) => {
  const sneakerId = req.params.id;
  const { name, sizes, brand, price, stock, image } = req.body;

  // Actualizar la información de la sneaker en la tabla sneakers
  const sneakerSql =
    "UPDATE sneakers SET name = ?, brand = ?, price = ?, image = ? WHERE id = ?";
  db.query(
    sneakerSql,
    [name, brand, price, image, sneakerId],
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

// Ruta para eliminar un sneaker por su ID
app.delete('/api/sneakers/:id', (req, res) => {
  const sneakerId = req.params.id;

  // Obtener el nombre de la imagen de la sneaker que se va a eliminar
  const imageNameSql = 'SELECT image FROM sneakers WHERE id = ?';
  db.query(imageNameSql, [sneakerId], (err, result) => {
    if (err) {
      return res.status(400).json({ message: err.message });
    } else {
      if (result.length === 0) {
        return res.status(404).json({ message: 'No se encontró la sneaker con el ID proporcionado' });
      } else {
        const imageName = result[0].image;
        const imagePath = path.join(__dirname, 'images', imageName);

        // Eliminar la imagen de la carpeta images
        fs.unlink(imagePath, (err) => {
          if (err) {
            console.error("Error al eliminar la imagen:", err);
          }
        });

        // Eliminar tallas de la sneaker en la tabla sneaker_sizes
        const sql = 'DELETE FROM sneaker_sizes WHERE sneaker_id = ?';
        db.query(sql, [sneakerId], (err, result) => {
          if (err) {
            return res.status(400).json({ message: err.message });
          } else {
            // Eliminar sneaker en la tabla sneakers
            const sneakerSql = 'DELETE FROM sneakers WHERE id = ?';
            db.query(sneakerSql, [sneakerId], (err, result) => {
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
      }
    }
  });
});

