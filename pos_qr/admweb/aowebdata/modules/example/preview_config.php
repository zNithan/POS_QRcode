<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreviewDemo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div><?php echo $_SESSION['keys[enshortmessagefooter]']; ?></div>
    <div><?php echo $_SESSION['keys[facebooklinken]']; ?></div>
    <div><?php echo $_SESSION['keys[linkedinlinken]']; ?></div>
    <div><?php echo $_SESSION['keys[encopyright]']; ?></div>
    <div><?php echo $_SESSION['keys[addressen]']; ?></div>
    <div><?php echo $_SESSION['keys[phoneen]']; ?></div>
    <div><?php echo $_SESSION['keys[workingTimeen]']; ?></div>
    <div><?php echo $_SESSION['keys[workingDateen]']; ?></div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<!-- <pre>Array
(
    [formData] => ac=edit&id=94&status=y&group=0&displaytime=07%2F18%2F2024&endDate=09%2F23%2F2024&isEndDateShow=1&icon=&icon2=&checkOption=0&extra1=&extra2=&extra3=&extra4=&extra5=&extra6=&extra7=&extra8=&extra9=&extra10=&frm%5Bth%5D%5Bcontent_id%5D=&frm%5Bth%5D%5Bsubject%5D=test00012&frm%5Bth%5D%5Bkeywords%5D=test00012&frm%5Bth%5D%5Bauthor%5D=test00012&frm%5Bth%5D%5BshortMessage%5D=test00012&frm%5Bth%5D%5Bcontent%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent2%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent3%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent4%5D=&frm%5Bth%5D%5Bcontent_extra1%5D=&frm%5Bth%5D%5Bcontent_extra2%5D=&frm%5Bth%5D%5Bcontent_extra3%5D=&frm%5Ben%5D%5Bcontent_id%5D=&frm%5Ben%5D%5Bsubject%5D=-%20-%20No%20title%20-%20-&frm%5Ben%5D%5Bkeywords%5D=&frm%5Ben%5D%5Bauthor%5D=&frm%5Ben%5D%5BshortMessage%5D=&frm%5Ben%5D%5Bcontent%5D=&frm%5Ben%5D%5Bcontent2%5D=&frm%5Ben%5D%5Bcontent3%5D=&frm%5Ben%5D%5Bcontent4%5D=&frm%5Ben%5D%5Bcontent_extra1%5D=&frm%5Ben%5D%5Bcontent_extra2%5D=&frm%5Ben%5D%5Bcontent_extra3%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=
    [keysname] => article
    [login] => 1
    [logout_time] => 1727084513
    [login_time] => 1727069923
    [mdusertext] => eyJsb2dpbiI6dHJ1ZSwidXNlcl9pZCI6IjEiLCJ1c2VyIjoic3VwZXJhZG1pbiIsIm5hbWUiOiJcdTBlMTlcdTBlMzJcdTBlMjIgQW9zb2Z0IERlZmF1bHRMb2dpbiIsImVtYWlsIjoiaW5mb0Bhb3NvZnQuY28udGgiLCJzdGF0dXMiOiJhZG1pbiIsInBpY3R1cmUiOiJtZW1iZXJcLzEucG5nIiwicmVnaW9uIjpudWxsLCJtb2R1bGVzIjoiYWxsIn0=
    [status] => y
    [group] => 0
    [displaytime] => 09/23/2024
    [endDate] => 09/23/2024
    [isEndDateShow] => 1
    [icon] => 
    [icon2] => 
    [extra1] => 
    [extra2] => 
    [extra3] => 
    [extra4] => 
    [extra5] => 
    [extra6] => 
    [extra7] => 
    [extra8] => 
    [extra9] => 
    [extra10] => 
    [frm[th][content_id]] => 
    [frm[th][subject]] => 
    [frm[th][keywords]] => 
    [frm[th][author]] => 
    [frm[th][shortMessage]] => 
    [frm[th][content]] => 
    [frm[th][content2]] => 
    [frm[th][content3]] => 
    [frm[th][content4]] => 
    [frm[th][content_extra1]] => 
    [frm[th][content_extra2]] => 
    [frm[th][content_extra3]] => 
    [frm[en][content_id]] => 
    [frm[en][subject]] => 
    [frm[en][keywords]] => 
    [frm[en][author]] => 
    [frm[en][shortMessage]] => 
    [frm[en][content]] => 
    [frm[en][content2]] => 
    [frm[en][content3]] => 
    [frm[en][content4]] => 
    [frm[en][content_extra1]] => 
    [frm[en][content_extra2]] => 
    [frm[en][content_extra3]] => 
    [attachTextFileList[0]] => 
    [attachTextFileList[1]] => 
    [attachTextFileList[2]] => 
    [attachTextFileList[3]] => 
    [attachTextFileList[4]] => 
    [attachTextFileList[5]] => 
    [attachTextFileList[6]] => 
    [attachTextFileList[7]] => 
    [ac] => update
    [keys[enshortmessagefooter]] => 
    [keys[facebooklinken]] => 
    [keys[linkedinlinken]] => css/themes/type-a/theme-gray.min.css
    [keys[encopyright]] => 
    [keys[addressen]] => 
    [keys[phoneen]] => 
    [keys[workingTimeen]] => 
    [keys[workingDateen]] => 
)
</pre> -->