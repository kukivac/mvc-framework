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
const add_news_article_form_element = document.getElementById('add-news-article-form');
const delete_news_article_elements = document.querySelectorAll('.delete-news-article-button');
const delete_articles_article_elements = document.querySelectorAll('.delete-articles-article-button');
if(login_form_element)
{
    login_form_element.addEventListener('submit', function(e){
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Collect form data

        fetch(getLink('/user/ajax/login'), {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Login was succesfull")
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

        fetch(getLink('/user/ajax/register'), {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Registration was succesfull")
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

        fetch(getLink('/articles/ajax/add'), {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("Article was added")
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
if(add_news_article_form_element)
{
    add_news_article_form_element.addEventListener('submit', function(e){
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Collect form data

        fetch(getLink('/news/ajax/add'), {
            method: 'POST',
            body: formData
        })
                .then(response => response.json())
                .then(data => {
                    if(data.hasOwnProperty("data"))
                    {
                        alert("News was added")
                        window.location.href = getLink('/news?id=' + data.id);
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
if(delete_news_article_elements)
{
    delete_news_article_elements.forEach(element => {
        element.addEventListener('click', function(){
            fetch(getLink('/news/ajax/delete?id=' + element.getAttribute("article-id")), {
                method: 'POST',
            })
                    .then(response => response.json())
                    .then(data => {
                        if(data.hasOwnProperty("data"))
                        {
                            let specificValue = element.getAttribute("article-id");
                            let selector = `.news-article-card[article-id="${specificValue}"]`;

                            let elements = document.querySelectorAll(selector);

                            elements.forEach(element => {
                                element.remove();
                            });
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
        })
    })
}
if(delete_articles_article_elements)
{
    delete_articles_article_elements.forEach(element => {
        element.addEventListener('click', function(){
            fetch(getLink('/articles/ajax/delete?id=' + element.getAttribute("article-id")), {
                method: 'POST',
            })
                    .then(response => response.json())
                    .then(data => {
                        if(data.hasOwnProperty("data"))
                        {
                            let specificValue = element.getAttribute("article-id");
                            let selector = `.articles-article-card[article-id="${specificValue}"]`;

                            let elements = document.querySelectorAll(selector);

                            elements.forEach(element => {
                                element.remove();
                            });
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
        })
    })
}