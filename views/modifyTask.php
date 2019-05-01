<html>
<head>
    <meta charset="utf-8">
    <title>Расписание</title>
</head>
<body>
<?='<form action="/Tasks/modifyTask/' . $dataArr->Id . '"' . ' method="post">'?>
    <input type="hidden" name="RowNumber" value="<?=$dataArr->Id?>">
    <input type="date" name="Date" value="<?=date("Y-m-d", (int)$dataArr->DeadLine)?>">
    <input type="text" name="Task" value="<?=$dataArr->Task?>">
    <input name="SaveBtn" value="Сохранить" type="submit">
</form>
</body>
</html>
