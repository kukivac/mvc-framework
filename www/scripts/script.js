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

document.getElementById('login-form').addEventListener('submit', function(e){
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
                    window.location.href = getLink('/matice');
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