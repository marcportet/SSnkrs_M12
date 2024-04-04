const express = require('express');
const bodyParser = require('body-parser');
const db = require('./db');

const app = express();
const PORT = 3000;

app.use(bodyParser.json());

// Ruta para obtener todos los sneakers
app.get('/api/sneakers', (req, res) => {
  const sql = 'SELECT * FROM sneakers';
  db.query(sql, (err, result) => {
    if (err) {
      res.status(500).json({ message: err.message });
    }
    res.json(result);
  });
});

// Ruta para crear un nuevo sneaker
app.post('/api/sneakers', (req, res) => {
  const { name, size, brand, image, reference } = req.body;

  const sql = 'INSERT INTO sneakers (name, size, brand, image, reference) VALUES (?, ?, ?, ?, ?)';
  db.query(sql, [name, size, brand, image, reference], (err, result) => {
    if (err) {
      res.status(400).json({ message: err.message });
    }
    res.status(201).json({ message: 'Sneaker creado exitosamente' });
  });
});

// Iniciar el servidor
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
