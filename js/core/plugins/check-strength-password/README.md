# jQuery-Password-Strength-Checker
jQuery password strength checker with indicated password strength


## Getting Started

```html
<form>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    <div id="password-strength-status"></div>
	<ul class="pswd_info" id="passwordCriterion">
		<li data-criterion="length" class="invalid">8-15 <strong>Characters</strong></li>
		<li data-criterion="capital" class="invalid">At least <strong>one capital letter</strong></li>
		<li data-criterion="small" class="invalid">At least <strong>one small letter</strong></li>
		<li data-criterion="number" class="invalid">At least <strong>one number</strong></li>
		<li data-criterion="special" class="invalid">At least <strong>one Specail Characters </strong></li>
	</ul>
</form>

```
### Add CSS File
```html	
	<!-- Password Strenth CSS -->
	<link rel="stylesheet" href="asset/password-strength.css">
```


### Add Javascript File
```html
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<!-- Password Strenth Script -->
	<script type="text/javascript" src="asset/password-strength.js"></script>
```
### Script
```js
	$('#password').keyup(function(event) {
		var password = $('#password').val(); /* your Password Field */
		checkPasswordStrength(password);
	});
```
​

## Credits
https://vadnaitik.com

See the [Contributing Guidelines](CONTRIBUTING.md) for details.