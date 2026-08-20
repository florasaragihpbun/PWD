document.addEventListener("DOMContentLoaded", function() {
    checkRegistrationValidation();
    setupScheduleFeatures();
    setupBackToTop();
    setupJQueryFeatures();
});

function checkRegistrationValidation() {
    let form = document.querySelector(".registration-form");

    if (!form) {
        return;
    }

    form.addEventListener("submit", function(event) {
        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let phone = document.getElementById('phone').value.trim();
        let institution = document.getElementById('institution').value.trim();

        if(name === '' && email === '' && phone === '' && institution === ''){
            event.preventDefault();
            alert('Data tidak boleh kosong.');
            return;
        }else if (name === '' || email === '' || phone === '' || institution === '') {
            if(name === '') {
                alert('Nama tidak boleh kosong.');
            }
            else if(email === '') {
                alert('Email tidak boleh kosong.');
            }
            else if(phone === '') {
                alert('Nomor telepon tidak boleh kosong.');
            }
            else if(institution === '') {
                alert('Institusi tidak boleh kosong.');
            }
            event.preventDefault();
            return;
        }

        if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
            event.preventDefault();
            alert('Email tidak valid.');
            return;
        }

        if (phone.length < 10 || phone.length > 15 || !/^\d+$/.test(phone)) {
            event.preventDefault();
            alert('Nomor telepon tidak valid.');
            return;
        }

        let confirmed = window.confirm(
            "Apakah data pendaftaran sudah benar?"
        );

        if (!confirmed) {
            event.preventDefault();
        }
    });
}

function setupScheduleFeatures() {
    if (typeof window.jQuery === "undefined") {
        return;
    }

    let $ = window.jQuery;
    let $filter = $("#schedule-filter");
    let $rows = $(".schedule-table .table-row");

    if (!$filter.length) {
        return;
    }

    $filter.on("input", function () {
        let keyword = $.trim($(this).val()).toLowerCase();

        $(".schedule-detail").remove();
        $rows.removeClass("selected-row");

        $rows.each(function () {
            let $row = $(this);
            let content = $row.text().toLowerCase();
            let isMatch = content.indexOf(keyword) !== -1;

            $row.toggle(isMatch);
        });
    });
}

function setupBackToTop() {
    let button = document.createElement("button");

    button.type = "button";
    button.id = "back-to-top";
    button.textContent = "Kembali ke atas";
    button.style.display = "none";

    document.body.appendChild(button);

    window.addEventListener("scroll", function () {
        button.style.display = window.scrollY > 500 ? "block" : "none";
    });

    button.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
}

function setupJQueryFeatures() {
    if (typeof window.jQuery === "undefined") {
        return;
    }

    let $ = window.jQuery;

    $(".schedule-table .table-row").on("click", function () {
        let $row = $(this);
        let $detail = $row.next(".schedule-detail");

        $(".schedule-table .table-row").removeClass("selected-row");
        $(".schedule-detail").not($detail).stop(true, true).slideUp(200, function () {
            $(this).remove();
        });

        if ($detail.length) {
            $row.toggleClass("selected-row");
            $detail.stop(true, true).slideToggle(200);
            return;
        }

        let activity = $row.children().eq(1).text();
        let description = $row.children().eq(2).text();
        let moderator = $row.children().eq(3).text();
        let detailRow = $("<tr class='schedule-detail'><td colspan='4'></td></tr>");

        detailRow.find("td").text(
            "Detail " + activity + " | Moderator: " + moderator + " | " + description
        );

        $row.addClass("selected-row");
        detailRow.hide().insertAfter($row).slideDown(200);
    });
}