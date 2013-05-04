"""
    REQUIREMENTS:
        - install pip with distribute (http://packages.python.org/distribute/)
        - sudo pip install Fabric

"""

from fabric.api import local

def lang(mode="extract"):
    """
        REQUIREMENTS:

        - Install before pip with distribute_setup.py (Read the environment setup document)
        - sudo pip install babel
        - sudo pip install jinja2

        HOW TO RUN:

            option 1) fab lang
            option 2) fab lang:compile
    """

    if mode == "compile":
        local("pybabel compile -f -d ./locale")
    else:
        local("pybabel extract -F ./locale/babel.cfg -o ./locale/messages.pot ./ --sort-output --no-location --omit-header")
        local("pybabel update -l en_US -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l es_ES -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l it_IT -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l zh_CN -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l id_ID -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l fr_FR -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l de_DE -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l ru_RU -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")
        local("pybabel update -l pt_BR -d ./locale -i ./locale/messages.pot --previous --ignore-obsolete")

def start(mode="normal"):
    """ start the local app server """
    local("dev_appserver.py .")

def deploy(app_id="genetic-memorial", version="2-2"):
    """ upload the app """
    local("appcfg.py --oauth2 update .")

def commit(m="Auto-update the app"):
    """ save the to github """
    local("git add .")
    local("git commit -m '{0}'".format(m))
    local("git push")

def test(os="mac"):
    """
        REQUIREMENTS:
        - install pip with distribute (http://packages.python.org/distribute/)
        - sudo pip install mock
        - sudo pip install webtest
        - sudo pip install pyquery

        HOW TO RUN:

            option 1) fab test
            option 2) fab test:mac
            option 3) fab test:linux

    """
    path = {
        "mac": "/usr/local/google_appengine",
       }[os]

    local("python testrunner.py {0} ./".format(path))