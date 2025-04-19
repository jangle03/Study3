let tuVungDangChonId = null;

        function xemChiTiet(tuVung, nguoiThem, ngayThem, nghiaTV, idTuVung) {
            document.getElementById("modalTuVung").textContent = tuVung;
            document.getElementById("modalNguoiThem").textContent = nguoiThem;
            document.getElementById("modalNgayThem").textContent = ngayThem;
            document.getElementById("modalNghia").textContent = nghiaTV;

            tuVungDangChonId = idTuVung;
            document.getElementById("modalChiTiet").style.display = "block";
        }

        function dongModal() {
            document.getElementById("modalChiTiet").style.display = "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById("modalChiTiet");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        function xoaTuVung() {
            if (!tuVungDangChonId) return;
        
            // Đóng modal trước khi mở SweetAlert
            dongModal(); 
        
            Swal.fire({
                title: 'Are you sure?',
                text: "This vocabulary will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('', {
                        delete_vocab_id: tuVungDangChonId
                    }, function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire('Deleted!', 'Vocabulary has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'Unable to delete the vocabulary.', 'error');
                        }
                    });
                }
            });
        }
        