Page Batch SEO Validator
=======

Features
---
This tool was developed to facilitate the validation of SEO rules applied to pages. You can define a set of URLs, rules and values that we will test against. 

For the time being it only allows for substring checks inside the source code.



Usage
---
Define the pages you wish to validate inside pages.json. Provide a URL, a regex rule and the expected value like so:
```json
[
    {
        "url": "https://example.com", 
        "expected": {
            "rule": "/<title[^>]*>([^<]*)<\\/title>/", 
            "value": "Example Domain"
        }
    },
    {
        "url": "https://anotherexample.com", 
        "expected": {
            "rule": "/<title [^>]*>([^<]*)<\\/title>/", 
            "value": "The value you expect to be found"
        }
    }
]

```

Start a web server if you don't already have one running...
```bash
$ php -S localhost:8000
```

... and access http://localhost:8000 on your browser.