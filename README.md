# flurry-back
before start:
1. composer install - install bundles
2. php bin/console doctrine:migrations:migrate - install changes in DB

star server: symfony server:start
star server on backgrounf: symfony server:start -d

Products catalog:
  api_get_all_products       GET       /api/products  
  api_get_product            GET       /api/products/{id}
  api_add_product            POST      /api/products
  api_edit_product           PUT|PATCH /api/products/{id}
  api_delete_product         DELETE    /api/products/{id}

  Menu catalog:
  api_get_all_positions      GET         /api/menu
  api_get_position           GET         /api/menu/{id}
  api_add_position           POST        /api/menu
  api_edit_position          PUT|PATCH   /api/menu/{id}
  api_delete_position        DELETE      /api/menu/{id}