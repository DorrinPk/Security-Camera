from flask_wtf import Form
from wtforms import StringField, PasswordField
from wtforms.validators import (DataRequired, Regexp, ValidationError, Email, Length, EqualTo)

from models import User

def name_exists(form, field):
	if User.select().where(User.user == field.data).exists():
		raise ValidationError('User with that name already exits.')

class RegisterForm(Form):
	user = StringField(
		'User',
		validators=[
			DataRequired(),
			Regexp(
				r'^[a-zA-Z0-9_]+$',
				message="Name should be one word"
			)])
	password = PasswordField(
			'Password',
			validators=[
				DataRequired(),
				Length(min=2),
				EqualTo('password2', message='Password must match')
		])
	password2 = PasswordField(
			'Confirm Password',
			validators=[DataRequired()]
	)

class LoginForm(Form):
	user = StringField('User',validators=[DataRequired()])
	password = PasswordField('Password', validators=[DataRequired()])
