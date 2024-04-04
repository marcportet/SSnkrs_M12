const mysql = require('mysql');

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'pruebaApi',
});

db.connect((err) => {
  if (err) {
    throw err;
  }
  console.log('Conexión a MySQL establecida');
});

module.exports = db;
