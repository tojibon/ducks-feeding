[Go Back](INDEX.md)

## Foods Endpoint
Foods controller related available RESTful endpoints.

**Author**: Juyal Ahmed   
**Email**: juyal.ahmed.12@gmail.com   
**Last Modified**: 01.Mar.2019   

#### Foods

**Display records of foods resource.**   
`GET` - `/foods` - `200 OK`     

**Available parameters for response filtering**   
* int `$food_type_id` food_types.id pk of food_types table

**ResponseBody:**  
```json
[
   {
      "id":2,
      "type":{
         "id":1,
         "name":"FIsh"
      },
      "name":"Common Carp"
   },
   {
      "id":3,
      "type":{
         "id":1,
         "name":"FIsh"
      },
      "name":"Goldfish"
   },
   {
      "id":1,
      "type":{
         "id":1,
         "name":"FIsh"
      },
      "name":"Siamese"
   }
]
```
