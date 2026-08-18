document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("mahasiswaForm");

    if (form) {

        form.addEventListener("submit", function (event) {

            const nim =
                document.getElementById("nim").value.trim();

            const nama =
                document.getElementById("nama").value.trim();

            const jurusan =
                document.getElementById("id_jurusan").value;

            if (nim === "") {

                alert("NIM wajib diisi!");

                event.preventDefault();

                return;
            }

            if (nama === "") {

                alert("Nama wajib diisi!");

                event.preventDefault();

                return;
            }

            if (jurusan === "") {

                alert("Jurusan wajib dipilih!");

                event.preventDefault();

                return;
            }

        });

    }

});