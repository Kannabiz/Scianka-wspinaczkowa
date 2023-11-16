let wysw = localStorage.getItem("wyswietlany")

document.getElementById('panel1').style.display = 'none'
document.getElementById('panel1').style.pointerEvents = 'none'

document.getElementById('panel'+wysw).style.display = 'contents'
document.getElementById('panel'+wysw).style.pointerEvents = 'all'

function podmenu(i, admin) {
    if(admin == 1)
    {
        for(j = 1; j < 6; j++)
        {
            document.getElementById('panel'+j).style.display = 'none'
            document.getElementById('panel'+j).style.pointerEvents = 'none'
        }
        document.getElementById('panel'+i).style.display = 'contents'
        document.getElementById('panel'+i).style.pointerEvents = 'all'
        localStorage.setItem("wyswietlany", i);
    }
    else if(admin == 0)
    {
        for(j = 1; j < 4; j++)
        {
            document.getElementById('panel'+j).style.display = 'none'
            document.getElementById('panel'+j).style.pointerEvents = 'none'
        }
        document.getElementById('panel'+i).style.display = 'contents'
        document.getElementById('panel'+i).style.pointerEvents = 'all'
        localStorage.setItem("wyswietlany", i);
    }
}