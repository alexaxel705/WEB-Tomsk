<!DOCTYPE html>
<html lang="en">
<head> 
	<script type="text/javascript" src="/engine/java/scripts.js"></script>
	<script type="text/javascript" src="/engine/java/jquery-ui.min.js"></script>
</head> 

<script>
var tmptime=new Date().getTime();
var lasttime=new Date().getTime();
var morse_timeout_tr=false;
var morse_buffer="";


start_morse(35);

function start_morse(obj)
{
	$(document).keydown(function(e){
	        if(e.keyCode == obj)
		{
			if(morse_timeout_tr==true)
			{
				clearTimeout(morse_timeout);
			}
			tmptime=new Date().getTime();
			if(tmptime-lasttime > 300 && tmptime-lasttime < 700)morse_buffer+=" ";
			else if(tmptime-lasttime > 700)morse_buffer+=" | ";
		}
	}).keyup(function(e){
	        if(e.keyCode == obj)
		{
			if(new Date().getTime()-tmptime < 100)
			{

				morse_buffer+=".";
			}
			else
			{
				morse_buffer+="-";
			}
   			morse_timeout=setTimeout("morse_decode()", 300);
			morse_timeout_tr=true;
			lasttime=new Date().getTime();
		}
	});
}


function morse_decode()
{
	tmptime=new Date().getTime();

	obj=morse_buffer;
	obj=obj.split(' ');
	for (var i=0;i<obj.length;i++) 
	{
		$("#out_morse").append(morse_rpl(obj[i]));
		morse_buffer="";
	}
	morse_timeout_tr=false;
}



function morse_rpl(obj)
{
	switch (obj) {
        case "|": return " ";
        case ".-": return "a";
        case "-...": return "b";
        case ".--": return "w";
        case "--.": return "g";
        case "-..": return "d";
        case ".": return "e";
        case "...-": return "v";
        case "--..": return "z";
        case "..": return "i";
        case ".---": return "j";
        case "-.-": return "k";
        case ".-..": return "l";
        case "--": return "m";
        case "-.": return "n";
        case "---": return "o";
        case ".--.": return "p";
        case ".-.": return "r";
        case "...": return "s";
        case "-": return "t";
        case "..-": return "u";
        case "..-.": return "f";
        case "....": return "h";
        case "-.-.": return "c";
        case "---.": return "Ö";
        case "----": return "CH";
        case "--.-": return "q";
        case "--.--": return "Ñ";
        case "-.--": return "y";
        case "-..-": return "x";
        case "..-..": return "É";
        case "..--": return "Ü";
        case ".-.-": return "Ä";
        case ".----": return "1";
        case "..---": return "2";
        case "...--": return "3";
        case "....-": return "4";
        case ".....": return "5";
        case "-....": return "6";
        case "--...": return "7";
        case "---..": return "8";
        case "----.": return "9";
        case "-----": return "0";
        case "......": return ".";
        case ".-.-.-": return ",";
        case "---...": return ":";
        case "-.-.-.": return ";";
        case "-.--.-": return ")";
        case ".----.": return "'";
        case ".-..-.": return '"';
        case "-....-": return "-";
        case "-..-.": return "/";
        case "..--..": return "?";
        case "--..--": return "!";
        case ".---.": return "§";
        case "........": return "ошибка";
        case ".--.-.": return "@";
        case "..-.-": return "конец связи";
	default: return "";
	}
}
</script>

<br />
<div id="out_morse" style="width:100%;background-color:blue;color:white;height:100px;"></div>


</html>



