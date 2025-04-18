# 



/api/users

CONTRATO 

```
{
  "request": {
    "url": "/api/users",
    "method": "POST",
    "header": {
      "api-key": "string"
    },
    "body":{
    "name": "string",
    "email": "string",
    "role": "SOCIO" | "ADMIN" | "MEMBER"
}
  },
  "response": {
    "200": {
        "name": "string",
        "email": "string",
    }
  }
}
```