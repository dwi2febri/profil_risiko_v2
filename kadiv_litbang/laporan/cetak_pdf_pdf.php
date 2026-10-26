<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>PDF Viewer & Download</title>
</head>
<body>
  <h1>Pratinjau PDF</h1>
  <iframe id="pdf-frame" width="600" height="500"></iframe>
  <br><br>
  <button onclick="downloadWithWatermark()">Download</button>

  <!-- Tambahkan PDF-lib dari CDN -->
  <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
  <script>
    const pdfUrl = '../../file/Profil_risiko_final_tw1_2025.pdf'; // Ganti dengan URL PDF asli kamu

    // Tampilkan PDF di iframe
    document.getElementById('pdf-frame').src = pdfUrl;

    async function downloadWithWatermark() {
      const existingPdfBytes = await fetch(pdfUrl).then(res => res.arrayBuffer());
      const { PDFDocument, rgb } = PDFLib;
      const pdfDoc = await PDFDocument.load(existingPdfBytes);

      const pages = pdfDoc.getPages();
      const dateText = `Diunduh pada: ${new Date().toLocaleDateString('id-ID')} ${new Date().toLocaleTimeString('id-ID')}`;

      for (const page of pages) {
        page.drawText(dateText, {
          x: 50,
          y: 30,
          size: 10,
          color: rgb(0.8, 0.8, 0.8),
        });
      }

      const pdfBytes = await pdfDoc.save();

      const blob = new Blob([pdfBytes], { type: 'application/pdf' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = `file-watermarked.pdf`;
      link.click();
    }
  </script>
</body>
</html>


