# ![logo](https://github.com/mgp25/Instagram-API/raw/master/examples/assets/instagram.png) Get Instagram Followers on PHP

Export Instagram follower to MongoDB collection on PHP by using Instagram private API and recursive function.

**Read the [Instagram private API](https://github.com/mgp25/Instagram-API/blob/master/README.md)** docs if you are not familiar with this API.

### Installation

clone this repo

### Dependencies

`curl`, `gd` and `ffmpeg`

### What is inside config.json

This app developed to handle multiple accounts. You must add all accounts on config file, for example:

    {
      "account": {
        "alex": {
          "next": "",
          "log": {
            "count": 0
          }
        }
      }
    }

### How to work with my DB

Change the /vendor/Database.php file to configure connection to your DB or send it instance like on frameworks.

App will create insta_(user) collection for each new user. But you can easy change it.

### How to run

I use Linux console to run it, but it can be work on browser too.

     php app.php


# License

MIT

# Terms and conditions

- You will NOT use this App for marketing purposes (spam, massive sending...).
- We do NOT give support to anyone that wants this API to send massive messages or similar.
- We reserve the right to block any user of this repository that does not meet these conditions.

## Legal

This code is in no way affiliated with, authorized, maintained, sponsored or endorsed by Instagram or any of its affiliates or subsidiaries. This is an independent and unofficial App. Use at your own risk.
