.PHONY: htaccess
htaccess: wiki/.htaccess
wiki/.htaccess: .htaccess config/private/.htaccess
	cat $^ > $@
