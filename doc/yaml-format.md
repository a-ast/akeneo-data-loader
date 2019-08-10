# Examples of YAML format


### Channel

```yaml
-
    code: ecommerce
    currencies:
        - USD
        - EUR
    locales:
        - de_DE
        - en_US
        - fr_FR
    category_tree: master
    labels:
        en_US: Ecommerce
        de_DE: Ecommerce
        fr_FR: Ecommerce
-
    code: mobile
    currencies:
        - USD
        - EUR
    locales:
        - de_DE
        - en_US
        - fr_FR
    category_tree: master
    labels:
        en_US: Mobile
        de_DE: Mobil
        fr_FR: Mobile

```
See more in the [channel.yaml](examples/channel.yaml)


### Category

```yaml
-
    code: master_accessories_belts
    parent: master
    labels:
        en_US: Belts
        de_DE: Belts
        fr_FR: Belts
-
    code: master_accessories_bags
    parent: master
    labels:
        en_US: Bags
        de_DE: Bags
        fr_FR: Bags

```
See more in the [category.yaml](examples/category.yaml)


### Attribute group

```yaml
-
    code: ecommerce
    labels:
        en_US: Ecommerce
        fr_FR: Ecommerce
        de_DE: Ecommerce
-
    code: erp
    labels:
        en_US: ERP
        fr_FR: ERP
        de_DE: ERP

```
See more in the [attribute-group.yaml](examples/attribute-group.yaml)


### Attribute

```yaml
-
    code: brand
    type: pim_catalog_simpleselect
    group: marketing
    unique: false
    useable_as_grid_filter: false
    localizable: false
    scopable: false
    labels:
        de_DE: Brand
        en_US: Brand
        fr_FR: Marque
-
    code: collection
    type: pim_catalog_multiselect
    group: marketing
    unique: false
    useable_as_grid_filter: true
    localizable: false
    scopable: false
    labels:
        de_DE: Collection
        en_US: Collection
        fr_FR: Collection

```
See more in the [attribute.yaml](examples/attribute.yaml)


### Attribute option

```yaml
-
    code: akeneo
    attribute: brand
    labels:
        en_US: Akeneo
-
    code: autumn_2016
    attribute: collection
    labels:
        de_DE: 'Autumn 2016'
        en_US: 'Autumn 2016'
        fr_FR: 'Automne 2016'

```
See more in the [attribute-option.yaml](examples/attribute-option.yaml)


### Family

```yaml
-
    code: accessories
    attributes:
        - brand
        - collection
        - color
        - composition
        - description
        - ean
        - erp_name
        - image
        - keywords
        - material
        - meta_description
        - meta_title
        - name
        - notice
        - price
        - size
        - sku
        - supplier
        - variation_image
        - variation_name
        - weight
    attribute_as_label: name
    attribute_as_image: image
    attribute_requirements:
        ecommerce:
            - collection
            - description
            - ean
            - image
            - name
            - sku
            - variation_name
        mobile:
            - collection
            - ean
            - image
            - name
            - sku
            - variation_name
        print:
            - collection
            - ean
            - image
            - name
            - sku
            - variation_name
    labels:
        en_US: Accessories
        fr_FR: Accessories
        de_DE: Accessories
-
    code: shoes
    attributes:
        - brand
        - collection
        - color
        - composition
        - description
        - ean
        - erp_name
        - eu_shoes_size
        - image
        - keywords
        - material
        - meta_description
        - meta_title
        - name
        - notice
        - price
        - size
        - sku
        - sole_composition
        - supplier
        - top_composition
        - variation_image
        - variation_name
        - weight
    attribute_as_label: name
    attribute_as_image: image
    attribute_requirements:
        ecommerce:
            - collection
            - description
            - ean
            - eu_shoes_size
            - image
            - name
            - sku
        mobile:
            - collection
            - ean
            - eu_shoes_size
            - image
            - name
            - sku
        print:
            - collection
            - ean
            - eu_shoes_size
            - image
            - name
            - sku
    labels:
        en_US: Shoes
        fr_FR: Shoes
        de_DE: Shoes

```
See more in the [family.yaml](examples/family.yaml)


### Family variant

```yaml
-
    code: shoes_size
    family: shoes
    labels:
        de_DE: 'Schuhe nach Größe'
        en_US: 'Shoes by size'
        fr_FR: 'Chaussures par taille'
    variant_attribute_sets:
        -
            level: 1
            axes:
                - eu_shoes_size
            attributes:
                - ean
                - eu_shoes_size
                - size
                - sku
                - variation_image
                - variation_name
                - weight
-
    code: shoes_size_color
    family: shoes
    labels:
        de_DE: 'Schuhe nach Größe und Farbe'
        en_US: 'Shoes by size and color'
        fr_FR: 'Chaussures par taille et couleur'
    variant_attribute_sets:
        -
            level: 1
            axes:
                - size
            attributes:
                - eu_shoes_size
                - size
                - variation_name
                - weight
        -
            level: 2
            axes:
                - color
            attributes:
                - composition
                - color
                - ean
                - sku
                - variation_image

```
See more in the [family-variant.yaml](examples/family-variant.yaml)


### Product model

```yaml
-
    code: brooksblue
    family_variant: shoes_size
    categories:
        - master_men_shoes
    values:
        color:
            -
                locale: null
                scope: null
                data: blue
        collection:
            -
                locale: null
                scope: null
                data: [summer_2017]
        name:
            -
                locale: null
                scope: null
                data: 'Brooks blue'
        erp_name:
            -
                locale: en_US
                scope: null
                data: 'Brooks blue'
        description:
            -
                locale: en_US
                scope: ecommerce
                data: 'Brooks blue'
-
    code: brookspink
    family_variant: shoes_size
    categories:
        - master_women_shoes
    values:
        color:
            -
                locale: null
                scope: null
                data: pink
        collection:
            -
                locale: null
                scope: null
                data: [summer_2017]
        name:
            -
                locale: null
                scope: null
                data: 'Brooks pink'
        erp_name:
            -
                locale: en_US
                scope: null
                data: 'Brooks pink'
        description:
            -
                locale: en_US
                scope: ecommerce
                data: 'Brooks pink'

```
See more in the [product-model.yaml](examples/product-model.yaml)


### Product

```yaml
-
    identifier: '1111111171'
    enabled: true
    family: accessories
    categories:
        - master_accessories_bags
        - print_accessories
        - supplier_zaro
    values:
        ean:
            -
                locale: null
                scope: null
                data: '1234567890183'
        name:
            -
                locale: null
                scope: null
                data: Bag
        image:
            -
                locale: null
                scope: null
                data: '@file:asset/1111111171.jpg'
        weight:
            -
                locale: null
                scope: null
                data: { amount: '500.0000', unit: GRAM }
-
    identifier: '1111111183'
    enabled: true
    family: shoes
    parent: climbingshoe
    values:
        eu_shoes_size:
            -
                locale: null
                scope: null
                data: '410'
        weight:
            -
                locale: null
                scope: null
                data: { amount: '900.0000', unit: GRAM }

```
See more in the [product.yaml](examples/product.yaml)

