# Roundcube_TLS_Icon_with_Hmailserver

Displays a small icon after the subject line that displays the (presumed) encryption state of received mails. This plugin parses the "Received" header for the last hop and checks if TLS was used. 
Green signal: TLS1.2 or TLS1.3 
Blue signal: Internal message from localhost
If the encryption is correct, it will print out the details of its type.

Supported languages:
- English
- Hungarian
- German
- Russian
- Dutch

Update 1.0.0
- First release

Update 1.0.1
- Some bugfix
- Add Hungarian language

Update 1.0.2
- Link bug fix

Update 1.0.3
- Add IPv6 Support
- Add Dutch Language

Update 1.0.4
- Design Update
- Separate TLS version icon

Internal:
![image](https://user-images.githubusercontent.com/75365189/162017996-53bc3e67-936e-4528-8fd0-088c36e157f4.png)

External secure:
![image](https://user-images.githubusercontent.com/75365189/162018076-71264b4b-58bf-4f31-8ee1-757c98992ae8.png)
