Viper Tests
========================

Setup
-----
The following steps include setup for a SquizCI runner so that Viper can be tested via SquizCI. Note that the username for the operating systems for this setup is **squizlabs**.

###Mac
- Install JAVA Runtime 6+ (or wait till first test run where OSX prompts for Java installation).
- If Xcode popup is displayed when git command is run then install Git (http://git-scm.com/download/mac) and run the commands below to get git command working:
```
sudo rm -rf /usr/bin/git
sudo ln -s /usr/local/git/bin/git /usr/bin/git
```
- Setup Apache
```
mkdir ~/Sites
sudo nano /etc/apache2/users/squizlabs.conf
## Set the contents as the following ###
<Directory "/Users/squizlabs/Sites/">
  Options Indexes MultiViews FollowSymLinks
  AllowOverride All
  Order allow,deny
  Allow from all
</Directory>
#####
sudo nano /etc/apache2/httpd.conf
## Search for php and enable php by uncommenting the line. ##
#LoadModule php5_module libexec/apache2/libphp5.so
sudo apachectl start
```
- Create git config:
```
vi ~/.ssh/config
## Use the following content:
Host github.com
  Hostname github.com
  User git
  IdentityFile /Users/squizlabs/.ssh/labscheckout
```
- Setup private ssh key:
```
vi ~/.ssh/labscheckout
### Copy/Paste the key located here: https://opswiki.squiz.net/Matrix/Git?highlight=%28labscheckout%29#Mirroring_repositories
chmod 600 ~/.ssh/labscheckout
```
- Checkout Viper:
```
cd ~/Sites
git clone --recursive git@github.com:squizlabs/Viper.git
```
- Test that everything is working
```
cd ~/Sites/Viper/Tests
php runTests.php -bchrome -ttestStartOfParaBold --url=localhost/~squizlabs/Viper/Tests
```
- Note that if this setup is not going to be used as a SquizCI runner then following steps can be ignored.
- Add Host entry for the CI server.
- Add the runner.json:
```
cat ~/Sites/Viper/Tests/runner.json
{"projects":{"1":{"command":"php runTests.php -b[params:browser] -t[filter]","testPath":"/Users/squizlabs/Sites/Viper/Tests"}}}
```
- Add the runner script from CI to ~/Sites/Viper/Tests/runner.php.
- Add the Terminal.app to Assistive Devices list in System Preferences > Security & Privacy > Privacy > Accessibility.
- Open AppleScript Editor and add the following code:
```
on idle
    do shell script "php /Users/squizlabs/Sites/Viper/Tests/runner.php > /Users/squizlabs/Sites/Viper/Tests/cron.log 2>&1"
    return 60
end idle
```
- When **saving** make sure File Format is set to **Application** and tick **Stay open after run handler**.
- Put the App to somwhere like ~/Desktop and open it. This app will run the runner.php file every minute to look for CI tasks and run them. This app also needs to be added to the Assistive Devices list.
- The logs for the test run is located at ~/Sites/Viper/Tests/cron.log
- Create a new cron entry that will update progress every minute while a task is running:
```
*/1     *       *       *       *       php /Users/squizlabs/Sites/Viper/Tests/runner.php -c
```

###Windows
- Install Java Runtime 6+
- Install Github for Windows and all of its required .NET libs etc that it asks to be installed.
- Download and install [Visual C++ Redistributable for Visual Studio 2012 Update 4](http://www.microsoft.com/en-au/download/details.aspx?id=30679).
- Download and install [WampServer](http://www.wampserver.com/en).
- Add git for windows to PATH: C:\Users\squizlabs\AppData\Local\Github\Portable<randomNumbers>\
- Add new Environtment var: HOME=%USERPROFILE%
- Add PHP to PATH: c:\wamp\bin\php\php<PHP VERSION>
- Clone Viper using GitHub for Windows.
- Once done update the URLs to use SSH urls in git config:
```
notepad C:\wamp\www\Viper\.git\config
[core]
    repositoryformatversion = 0
    filemode = false
    bare = false
    logallrefupdates = true
    symlinks = false
    ignorecase = true
    hideDotFiles = dotGitOnly
[remote "origin"]
    url = git@github.com:squizlabs/Viper.git
    fetch = +refs/heads/*:refs/remotes/origin/*
[branch "master"]
    remote = origin
    merge = refs/heads/master
[submodule "Plugins/ViperAccessibilityPlugin/HTML_CodeSniffer"]
    url = git@github.com:squizlabs/HTML_CodeSniffer.git
[submodule "Tests/PHPSikuli"]
    url = git@github.com:squizlabs/php-sikuli.git
```
- Note that if this setup is not going to be used as a SquizCI runner then following steps can be ignored.
- Create runner settings file C:\wamp\www\runner.json :
```
{"projects":{"1":{"command":"php runTests.php -b[params:browser] -t[filter]","testPath":"C:\\wamp\\www\\Viper\\Tests\\"}}}
```
- Add the runner script from CI to C:\wamp\www\runner.php
- Download the CA root certificate bundle (PEM format) from http://curl.haxx.se/docs/caextract.html and place it in C:\wamp\www\cacert.pem
- Schedule runner task for windows (run cmd.exe ... command every 2 minutes)
```
schtasks /create /sc MINUTE /mo 2 /tn SquizRunner /tr "cmd.exe /c start /MIN 'Squiz Runner Task2' php C:\wamp\www\runner.php"
```
- Change power settings of the PC to not turn off:
```
powercfg -change -monitor-timeout-ac 0
powercfg -change -standby-timeout-ac 0
```

###Usage
Example manual test run:
```
cd Viper/Tests
# First run
php runTests.php -bfirefox -ttestStartOfParaBold -c --url=http://localhost/~squizlabs/Viper/Tests
# After calibration and the testing url is set
php runTests.php -bfirefox -ttestStartOfParaBold
```
