function xemChiTiet(tuVung, nguoiThem, ngayThem, nghia) {
        document.getElementById('modalTuVung').innerText = tuVung;
        document.getElementById('modalNguoiThem').innerText = nguoiThem;
        document.getElementById('modalNgayThem').innerText = ngayThem;
        document.getElementById('modalNghia').innerText = nghia;
        document.getElementById('modalChiTiet').style.display = 'block';
    }

    function dongModal() {
        document.getElementById('modalChiTiet').style.display = 'none';
    }

    function duyetTu(id) {
        fetch(`approve-word.php?id=${id}&action=approve`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật lại trạng thái sau khi duyệt
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                } else {
                    alert("There was an error browsing the vocabulary.");
                }
            });
    }

    function khongDuyetTu(id) {
        fetch(`approve-word.php?id=${id}&action=reject`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Cập nhật lại trạng thái sau khi không duyệt
                    location.reload(); // Tải lại trang để cập nhật trạng thái
                } else {
                    alert("There was an error browsing the vocabulary.");
                }
            });
    }