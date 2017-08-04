{{-- Шаблон письма с сообщением об ошибке системы --}}
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<br/>
		<h3>Исключение:</h3>
		<table border='1' cellpadding='5' cellspacing='0'>
			<tr>
				<td>Сообщение:</td> 
				<td>{{ $exception->getMessage() }}</td>
			</tr>
			<tr>
				<td>Код:</td> 
				<td>{{ $exception->getCode() }}</td>
			</tr>
			<tr>
				<td>Файл:</td> 
				<td>{{ $exception->getFile() }}</td>
			</tr>
			<tr>
				<td>Строка:</td> 
				<td>{{ $exception->getLine() }}</td>
			</tr>
		</table>
		<h3>Запрос:</h3>
		<table border='1' cellpadding='5' cellspacing='0'>
			<tr>
				<td>Метод:</td> 
				<td>{{ $request->method() }}</td>
			</tr>
			<tr>
				<td>Входные переменные:</td> 
				<td>{!! print_r($request->all(), TRUE) !!}</td>
			</tr>
			<tr>
				<td>УРЛ:</td> 
				<td>{{ $request->url() }}</td>
			</tr>
		</table>
	</body>
</html>
