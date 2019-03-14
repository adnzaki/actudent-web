var xhr = new XMLHttpRequest()
xhr.open('GET', `${baseURL}admin/hai`, true)
xhr.responseType = 'text'
xhr.onload = () => {
    document.getElementById('tulisan').innerHTML = xhr.responseText
}
xhr.send()
