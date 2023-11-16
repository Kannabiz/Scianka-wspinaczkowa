const menu1 = document.getElementById('przyciskMenu')
const menu2 = document.getElementById('przyciskMenu2')
const menu = document.getElementById('menu')

menu1.addEventListener("click", function()
{
    document.getElementById('div_blur').style.backdropFilter = 'blur(5px)'
    document.getElementById('div_blur').style.pointerEvents = 'all'
    if(menu.classList.contains("tymczasowyStan"))
    {
        menu.classList.remove("tymczasowyStan")
        menu.classList.add("wjazd")
    } 
    else
    {
        menu.classList.replace("wyjazd","wjazd")
    }
})

menu2.addEventListener("click", function()
{
    document.getElementById('div_blur').style.backdropFilter = 'blur(0px)'
    document.getElementById('div_blur').style.pointerEvents = 'none'
    menu.classList.replace("wjazd","wyjazd")
})