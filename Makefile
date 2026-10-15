WIKIS = en de fr hu id ja nl ru test oauth2 staging
CACHE_DIRS = $(addprefix cache/,$(WIKIS))
LOGS_DIRS = $(addprefix logs/,$(WIKIS))
IMAGES_DIRS = $(addprefix wiki/w/images/,$(WIKIS))

.PHONY: all
all: htaccess dirs

.PHONY: htaccess
htaccess: wiki/.htaccess
wiki/.htaccess: .htaccess images.htaccess config/private/.htaccess
	cat .htaccess > $@
	echo >> $@
	for WIKI in $(WIKIS); do \
		sed "s/SUBDOMAIN/$$WIKI/g" images.htaccess >> $@; \
		echo >> $@; \
	done
	echo 'Header set X-Image-Auth "%{IMG_AUTH}e" "env=IMG_AUTH"\n' >> $@
	cat config/private/.htaccess >> $@

.PHONY: dirs
dirs: | $(CACHE_DIRS) $(LOGS_DIRS) $(IMAGES_DIRS)
$(CACHE_DIRS) $(LOGS_DIRS) $(IMAGES_DIRS):
	mkdir -p $@
