
fighter

separate miniature data from computed properties.


#### New

mini data, selectors empty

#### Load

mini data, selectors, from db


## State

```js
factions: Object
    1: Object
        datasheets: Array
        description: String
        faction_keyword: String
        narrative: Array
        wargear: Array

killteam:
    name: String
    fighters: Array
        0: Object
            faction_id: Int
            miniature_id: Int
            name: String
            specialism_id: Int
            wargear_options: rm, can get from factions
            wargear_options_selected: Array
```
