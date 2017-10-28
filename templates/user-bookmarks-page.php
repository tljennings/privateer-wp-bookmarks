<?php

# Custom page template to view a list of bookmarks

# Unauthenticated Users:
# - without share request variable: redirect to login and return
# - with valid share request variable: display someone elses bookmark list
# Authenticated Users:
# - without share request variable: show own bookmarks with links and ability to delete
# - with valid share request variable: display someone elses bookmark list
# For users who can see reports
# - provide links to reports at bottom (hide when printed)