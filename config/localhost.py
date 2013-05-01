config = {

# webapp2 sessions
'webapp2_extras.sessions' : {'secret_key': '_PUT_KEY_HERE_YOUR_SECRET_KEY_'},

# webapp2 authentication
'webapp2_extras.auth' : {'user_model': 'boilerplate.models.User',
                         'cookie_name': 'session_name'},

# jinja2 templates
'webapp2_extras.jinja2' : {'template_path': ['templates','boilerplate/templates', 'admin/templates'],
                           'environment_args': {'extensions': ['jinja2.ext.i18n']}},

# application name
'app_name' : "Genetic Memorial",

# contact page email settings
'contact_sender' : "PUT_SENDER_EMAIL_HERE",
'contact_recipient' : "PUT_RECIPIENT_EMAIL_HERE",

# Password AES Encryption Parameters
'aes_key' : "12_24_32_BYTES_KEY_FOR_PASSWORDS",
'salt' : "_PUT_SALT_HERE_TO_SHA512_PASSWORDS_",

# get your own recaptcha keys by registering at http://www.google.com/recaptcha/
'captcha_public_key' : "PUT_YOUR_RECAPCHA_PUBLIC_KEY_HERE",
'captcha_private_key' : "PUT_YOUR_RECAPCHA_PRIVATE_KEY_HERE",

# Leave blank "google_analytics_domain" if you only want Analytics code
'google_analytics_domain' : "geneticmemorial.com",
'google_analytics_code' : "UA-40321962-1",

# add status codes and templates used to catch and display errors
# if a status code is not listed here it will use the default app engine
# stacktrace error page or browser error page
'error_templates' : {
    403: 'errors/default_error.html',
    404: 'errors/default_error.html',
    500: 'errors/default_error.html',
},

# Enable Federated login (OpenID and OAuth)
# Google App Engine Settings must be set to Authentication Options: Federated Login
'enable_federated_login' : False,

# jinja2 base layout template
'base_layout' : 'base.html',

# send error emails to developers
'send_mail_developer' : True,

# fellas' list
'developers' : (
    ('Ben Shope', 'ben@benshope.com'),
),

# If true, it will write in datastore a log of every email sent
'log_email' : False,

# If true, it will write in datastore a log of every visit
'log_visit' : False,

# ----> ADD MORE CONFIGURATION OPTIONS HERE <----

} # end config
