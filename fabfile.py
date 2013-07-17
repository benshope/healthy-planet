from fabric.api import local

# Start the development server - $ fab run
def run(mode="normal"):
    """ start the local app server """
    local("dev_appserver.py .")

# Upload the app to App Engine - $ fab upload
def upload(app_id="healthy-planet", version="2-2"):
    """ upload the app """
    local("appcfg.py --oauth2 update .")

# Save to github - $ fab save:m="First commit"
def save(m="Fab-update the app"):
    """ save the to github """
    local("git add .")
    local("git commit -a -m '{0}'".format(m))
    local("git push")

# Save to GitHub and upload to App Engine - $ fab update:m="First commit"
def update(m="Fab-update the app"):
    """ save the to github """
    local("git add .")
    local("git commit -a -m '{0}'".format(m))
    local("git push")
    local("appcfg.py --oauth2 update .")