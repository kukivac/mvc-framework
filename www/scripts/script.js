function isKrakenHost()
{
    return window.location.hostname === "kraken.pedf.cuni.cz";
}

function getLink(link)
{
    if(isKrakenHost())
    {
        return "/~kovacjaku" + link;
    }
    else
    {
        return link;
    }
}

const login_form_element = document.getElementById('login-form');
const register_form_element = document.getElementById('register-form');
const add_article_form_element = document.getElementById('add-article-form');
if(login_form_element)
{
    login_form_element.addEventListener('submit', function(e){
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Collect form data

        fetch('/user/ajax/login', {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Přihlášení proběhlo úspěšně")
                        window.location.href = getLink('/user/profile');
                    }
                    else if(data.hasOwnProperty("error"))
                    {
                        alert(data.error)
                    }
                    else
                    {
                        alert("There has been error")
                    }
                })
                .catch((error) => {
                    alert("There has been error")
                });
    });
}
if(register_form_element)
{
    register_form_element.addEventListener('submit', function(e){
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Collect form data

        fetch('/user/ajax/register', {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Registrace proběhla úspěšně")
                        window.location.href = getLink('/user/profile');
                    }
                    else if(data.hasOwnProperty("error"))
                    {
                        alert(data.error)
                    }
                    else
                    {
                        alert("There has been error")
                    }
                })
                .catch((error) => {
                    alert("There has been error")
                });
    });
}
if(add_article_form_element)
{
    add_article_form_element.addEventListener('submit', function(e){
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Collect form data

        fetch('/articles/ajax/add', {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Článek byl přidán")
                        window.location.href = getLink('/articles?id=' + data.id);
                    }
                    else if(data.hasOwnProperty("error"))
                    {
                        alert(data.error)
                    }
                    else
                    {
                        alert("There has been error")
                    }
                })
                .catch((error) => {
                    alert("There has been error")
                });
    });
}