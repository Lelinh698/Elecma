function date_time(id)
{
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
 //   months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
    d = date.getDate();
    day = date.getDay();
    days = new Array('CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7');
    h = date.getHours();
    if(h<10)
    {
            h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10)
    {
            m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10)
    {
            s = "0"+s;
    }
    result = ''+days[day]+' '+d+'-'+(month+1)+'-'+year+' '+h+':'+m+':'+s;
    document.getElementById(id).innerHTML = result;
    setTimeout('date_time("'+id+'");','1000');
    return true;
}
