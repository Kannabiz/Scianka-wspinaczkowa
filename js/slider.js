let i = 1;

function slider()
{
    if(i == 3)
    {
        i = 1;
    }
    else
    {
        i++;
    }

    document.getElementById("sliderZdj").src = "../img/Slider"+i+".png";
}

setInterval(slider, 6500);