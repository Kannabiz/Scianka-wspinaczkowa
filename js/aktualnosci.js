function aktO(m)
{
    document.getElementById('div_blur').style.backdropFilter = 'blur(5px)'
    document.getElementById('div_blur').style.pointerEvents = 'all'
    if(document.getElementById('info'+m).classList.contains('invis'))
    {
        document.getElementById('info'+m).classList.replace('invis','vis')
    }
    else if(document.getElementById('info'+m).classList.contains('invisT'))
    {
        document.getElementById('info'+m).classList.replace('invisT','vis')
    }
}

function aktZ(n)
{
    document.getElementById('info'+n).classList.replace('vis','invis')
    document.getElementById('div_blur').style.backdropFilter = 'blur(0px)'
    document.getElementById('div_blur').style.pointerEvents = 'none'
}