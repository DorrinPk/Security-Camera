import datetime

from flask.ext.bcrypt import generate_password_hash
from flask.ext.login import UserMixin
from peewee import *

DATABASE = SqliteDatabase('cam.db')

class User(UserMixin, Model):
	user = CharField(unique=True)
	password = CharField(max_length=100)
	joined_at = DateTimeField(default=datetime.datetime.now)
	is_admin = BooleanField(default=False)
	
	class Meta:
		database = DATABASE
		order_by = ('-joined_at',)

	@classmethod
	def create_user(cls, user, password, admin=False):
		try:
			cls.create(
				user=user,
				password=generate_password_hash(password),
				is_admin=admin)
		except IntegrityError:
			raise ValueError("Username already in use")

	def get_logs(self):
		return Post.select()

class Post(Model):
	timestamp = DateTimeField(default=datetime.datetime.now)
	who = TextField()
	
	class Meta:
		database = DATABASE
		order_by = ('-timestamp',) 

def initialize():
	DATABASE.connect()
	DATABASE.create_tables([User,Post], safe=True)
	DATABASE.close()
