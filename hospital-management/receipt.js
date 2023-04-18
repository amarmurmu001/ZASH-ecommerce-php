document.querySelector('#download-pdf').addEventListener('click', function () {
    html2canvas(document.querySelector('#outer')).then((canvas) => {
        let base64image = canvas.toDataURL('image/png');
        let pdf = new jsPDF('p', 'px', [1800, 1131]);
        pdf.addImage(base64image, 'PNG', 15, 15, 1090.800, 220);
        pdf.save('reciept.pdf');
    });
});