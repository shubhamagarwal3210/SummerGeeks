# Entry Management Software


An application, which can capture the Name, email address, phone no of the visitor and same information is also captured for the host on the front end.

At the back end, once the user enters the information in the form, the back end stores all of the information with time stamp of the entry.

This triggers an email and a SMS to the host informing him the details of his visitor.

There is also a provision of the checkout time which the guest has to provide once the meeting is over. This triggers an email to the guest with complete details of his visit.



## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

## Prerequisites

### 1.  Install Postfix for SMTP server

#### Installing Postfix as SMTP server using following command:

```bash
$ sudo apt-get install postfix
```


#### Installation & loading.


* Append the following to /etc/postfix.main.cf.

```bash
$ cat <<EOF | sudo tee -a /etc/postfix/main.cf
relayhost = [smtp.gmail.com]:587
smtp_sasl_auth_enable = yes
smtp_sasl_password_maps = hash:/etc/postfix/sasl_passwd
smtp_sasl_security_options = noanonymous
smtp_sasl_mechanism_filter = plain
smtp_use_tls = yes
EOF
```
* Create a file /etc/postfix/sasl_passwd. Replace GMAIL_ADDR with your Gmail address and GMAIL_PASSWD with your Gmail password.

```bash
$ echo "[smtp.gmail.com]:587 ${GMAIL_ADDR}:${GMAIL_PASSWD}" | \
sudo tee /etc/postfix/sasl_passwd
$ sudo chmod 600 /etc/postfix/sasl_passwd
$ sudo postmap hash:/etc/postfix/sasl_passwd
```

* Restart Postfix.

```bash
$ sudo systemctl restart postfix
```

 * If Gmail returns authentication error.

```
postfix/smtp ... SASL authentication failed; server smtp.gmail.com...
```

* The 2-step verification and application password is better. But this article uses "Allow less secure apps: ON".

```
https://myaccount.google.com/lesssecureapps
```

* If Gmail returns authenticaion error again, you need to ["Allow access to your Google account"](https://accounts.google.com/b/0/DisplayUnlockCaptcha).

```
https://accounts.google.com/DisplayUnlockCaptcha

```

* And then you can send mail to internet via Gmail. Mail's from address is your Gmail address.


```
postfix/smtp ... to=<yourgmail@gmail.com>,relay=smtp.gmail.com ...

```

### 2. Web Service API
To send Short Message Service(SMS) to a phone one need to have a Web Service API. 

Here I am using TextLocal (you can use other API also like Twillio and others)

#### Create you account in [Textlocal](https://www.textlocal.in/)(can ignore if already have one)
* This is the Dashboard which you will see once you sign up/log in, click help->All Documentation or visit this [link](https://control.textlocal.in/docs/) .


* Scroll down and click on [send SMS via PHP](https://control.textlocal.in/docs/api/code/post/).


* copy $username and $hash value from the [sample code](https://control.textlocal.in/docs/api/code/post/).

* Replace $username = "{Your username}" and $hash = "{Your Hash}" in Server.php.

### 3. Setting up the DataBase

* Replace the parameters of mysqli_connect();

```
mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
Eg:
$db = mysqli_connect('localhost', 'phpmyadmin', 'root', 'phpmyadmin');

```

* Create a table named ***Visitors*** in the previously provided DB_NAME Database with following properties:

Field      |   Type 
-----------|---------
VisitorName | varchar(255)
VisitorEmail | varchar(255)
VisitorContact | bigint(12)
HostName | varchar(255)
HostEmail | varchar(255)
HostContact | bigint(12)
Checkin | timestamp
Checkout | timestamp

and set the Checkout value to NULL by default.

You may execute the following query to do all this:

```
CREATE TABLE Visitors (
    VisitorName varchar(255),
    VisitorEmail varchar(255),
    VisitorContact bigint(12),
    HostName varchar(255),
    HostEmail varchar(255),
    HostContact bigint(12),
    Checkin timestamp,
    Checkout timestamp NULL DEFAULT NULL
);
```

## Authors

* **Shubham Agarwal** 

## Acknowledgments

* TextLocal API

