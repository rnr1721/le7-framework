/* global root, language */
window.addEventListener('load', function () {

    let vcodeInput = document.getElementById('vcode_input');
    vcodeInput.style.display = 'none';
    let vcode = document.getElementById('vcode');
    let login = document.getElementById('login');
    let btn = document.getElementById("vcode_button");

    btn.addEventListener("click", function () {

        let url = root + "/admin/login/vcode?login=" + login.value;
        let http = new XMLHttpRequest();

            http.open("GET", url, true);
            http.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            http.setRequestHeader('Content-Language', language);
            http.onreadystatechange = function ()
            {
                if (http.readyState === 4 && http.status === 200) {
                    let result = JSON.parse(http.responseText);
                    if (result.success) {
                        vcodeInput.style.display = 'block';
                        btn.style.display = 'none';
                    }
                } else {
                    login.style.borderColor = "red"; 
                    login.focus();
                }
            };
            http.send(null);


    });

});
