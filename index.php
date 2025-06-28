const express = require('express');
const mysql = require('mysql2/promise');
const os = require('os');
const app = express();
const port = 3000;

// RDS connection info
const db = mysql.createPool({
  host: 'mydb2.c1i02sci8x5p.us-east-1.rds.amazonaws.com',
  user: 'admin',
  password: 'dieulinh',
  database: 'myDB'
});

app.get('/', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM city');
    const totalPopulation = rows.reduce((sum, row) => sum + row.population, 0);
    const privateIP = getPrivateIP();

    let html = `<h1>Private IP: ${privateIP}</h1>`;
    html += `<h2>Tổng dân số: ${totalPopulation.toLocaleString()}</h2>`;
    html += `<table border="1"><tr><th>ID</th><th>Tên TP</th><th>Quốc gia</th><th>Dân số</th></tr>`;

    rows.forEach(city => {
      html += `<tr>
        <td>${city.id}</td>
        <td>${city.name}</td>
        <td>${city.country}</td>
        <td>${city.population.toLocaleString()}</td>
      </tr>`;
    });

    html += '</table>';
    res.send(html);
  } catch (err) {
    res.status(500).send('Lỗi kết nối hoặc truy vấn DB: ' + err.message);
  }
});

// Lấy IP nội bộ (Private IP)
function getPrivateIP() {
  const interfaces = os.networkInterfaces();
  for (const name in interfaces) {
    for (const iface of interfaces[name]) {
      if (iface.family === 'IPv4' && !iface.internal) {
        return iface.address;
      }
    }
  }
  return 'Không tìm thấy';
}

app.listen(port, () => {
  console.log(`App chạy tại http://localhost:${port}`);
});
