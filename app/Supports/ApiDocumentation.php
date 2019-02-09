<?php

namespace App\Supports;
use Illuminate\Http\Request;
use App\Models\Pages;
use App\Supports\ApiDocumentationTrait;

class ApiDocumentation {
  use ApiDocumentationTrait;

  static function DEFAULT_HEADERS() {
    return [
      "Content-Type" => "application/json",
      "Accept"       => "application/json",
      "x-api-key"    => env("API_KEY")
    ];
  }

  static function AUTH_HEADERS() {
    return ["Authorization" => "Bearer {token}"];
  }

  const CATEGORIES = [
    "auth",
    "waterbase",
    "account",
    "utilities",
    "products",
    "address",
    "orders",
    "cart",
    "rating",
    "service_request"
  ];

  public function all($categories = null) {
    $endpoints = [];
    if ($categories) {
      foreach ($categories as $category) {
        $endpoints = array_merge($endpoints, $this -> {$category}());
      }
      return $endpoints;
    }

    foreach (self::CATEGORIES as $category) {
      $endpoints = array_merge($endpoints, $this -> {$category}());
    }
    return $endpoints;
  }

  public function get($route, $method) {
    foreach (self::CATEGORIES as $category) {
      foreach ($this -> {$category}() as $endpoint) {
        if ($endpoint["url"] === $route && $endpoint["method"] === $method) {
          return $endpoint;
        }
      }
    }
    return [];
  }

  public function waterbase() {
    return [
      [
        "name"        => "Upload images (totally not stolen from firebase)",
        "headers"     => self::DEFAULT_HEADERS(),
        "url"         => "/api/media",
        "method"      => "post",
        "description" => "Upload images",
        "parameters"  => function () {
          return [
            [
              "name"       => "images",
              "type"       => "post",
              "validation" => "required[#]image"
            ]
          ];
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => ["images" => ["http://foo.bar.com/media/a-random-image.png"]],
            ]
          ];
        }
      ]
    ];
  }
  public function rating() {
    return [
      [
        "name"        => "Create ratings (rate a product)",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/rate",
        "method"      => "post",
        "description" => "Rate a product",
        "parameters"  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\RateRequest());
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => ["message" => trans("api.added_successfully")]
            ]
          ];
        }
      ],
      [
        "name"        => "Update ratings",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/rate/{id}",
        "method"      => "put",
        "description" => "Update an existing rating for a product",
        "parameters"  => function () {
          return array_merge(
            $this -> getParameters("id"),
            $this -> postParameters(new \App\Http\Requests\Api\RateRequest())
          );
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => ["message" => trans("api.updated_successfully")]
            ]
          ];
        }
      ],
      [
        "name"        => "Delete ratings",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/rate/{id}",
        "method"      => "delete",
        "description" => "Delete an existing rating for a product",
        "parameters"  => function () { return $this -> getParameters("id"); },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => ["message" => trans("api.deleted_successfully")]
            ]
          ];
        }
      ]
    ];
  }

  public function orders() {
    return [
      [
        'name'        => 'Get all orders',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{type}',
        'method'      => 'GET',
        'description' => 'Get all the orders for the logged in user',
        'parameters'  => function () {
          return [
            [
              "type"       => "GET",
              "validation" => "required|in:pending,completed",
              "name"       => "type"
            ]
          ];
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\OrderResource::collection(
                    \App\Models\Order::limit(10) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Get specific order',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}',
        'method'      => 'GET',
        'description' => 'Get a specific order with its products by id',
        'parameters'  => function () {
          return $this -> getParameters("id");
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  (new \App\Http\Resources\EditableOrderResource(
                    \App\Models\Order:: first()
                  )) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Create order (Create an order from the cart items)',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order',
        'method'      => 'POST',
        'description' => 'Create an order from the cart items',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\OrderRequest());
        },
        'responses' => function () {
          return [
            [
              'code' => 201,
              'data' => [
                'id'      => 22,
                'message' => trans('api.added_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Update order',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}',
        'method'      => 'PUT',
        'description' => 'Update an order (It will get the new data from the cart)',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters("id"),
            $this -> postParameters(new \App\Http\Requests\Api\OrderRequest())
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.updated_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Delete order',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}',
        'method'      => 'DELETE',
        'description' => 'Delete an existing order',
        'parameters'  => function () {
          return $this -> getParameters("id");
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.deleted_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Add order product',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}/product',
        'method'      => 'POST',
        'description' => 'Add a product to the order (only works if the order\'s status is pending)',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters("id"),
            $this -> postParameters(new \App\Http\Requests\Api\OrderProductRequest())
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 201,
              'data' => [
                'message' => trans('api.added_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Update order product',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}/product',
        'method'      => 'PUT',
        'description' => 'Update an existing product in the order (only works if the order\'s status is pending)',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters("id"),
            $this -> postParameters(new \App\Http\Requests\Api\OrderProductRequest())
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.updated_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Delete order product',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/order/{id}/product',
        'method'      => 'DELETE',
        'description' => 'Delete an existing product in the order (only works if the order\'s status is pending)',
        'parameters'  => function () {
          return $this -> getParameters("id");
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.deleted_successfully')
              ]
            ]
          ];
        }
      ],
    ];
  }

  public function cart() {
    return [
      [
        'name'        => 'Get all cart items',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/cart',
        'method'      => 'GET',
        'description' => 'Get all the cart items for the logged in user',
        'parameters'  => function () {
          return [];
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\CartResource::collection(
                    \App\Models\Cart::limit(5) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Add item to the cart',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/cart',
        'method'      => 'POST',
        'description' => 'Add item to the cart',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\CartRequest());
        },
        'responses' => function () {
          return [
            [
              'code' => 201,
              'data' => [
                'data' => 
                (new \App\Http\Resources\CartResource(
                      \App\Models\Cart:: first()
                )) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Update cart item\'s quantity',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/cart/{id}',
        'method'      => 'PUT',
        'description' => 'Update a cart item\'s quantity',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters("id"),
            $this -> postParameters(new \App\Http\Requests\Api\CartRequest())
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 201,
              'data' => [
                'data' => 
                  (new \App\Http\Resources\CartResource(
                      \App\Models\Cart:: first()
                  )) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Delete cart item',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/cart/{id}',
        'method'      => 'DELETE',
        'description' => 'Delete an item from the cart',
        'parameters'  => function () {
          return $this -> getParameters("id");
        },
        'responses' => function () {
          return [
            [
              'code' => 201,
              'data' => [
                'message' => trans('api.deleted_successfully')
              ]
            ]
          ];
        }
      ]
    ];
  }

  public function address() {
    return [
      [
        'name'        => 'Get all addresses',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/address',
        'method'      => 'GET',
        'description' => 'Get all addresses for the logged in user',
        'parameters'  => function () {
          return [];
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\AddressResource::collection(
                    \App\Models\Address::limit(10) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Create address',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/address',
        'method'      => 'POST',
        'description' => 'Create a new address for the logged in user',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\AddressRequest());
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.added_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Update address',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/address/{id}',
        'method'      => 'PUT',
        'description' => 'Update an existing address for the logged in user',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters('id'),
            $this -> postParameters(new \App\Http\Requests\Api\AddressRequest())
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.updated_successfully')
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Delete address',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/address/{id}',
        'method'      => 'DELETE',
        'description' => 'Delete an existing address for the logged in user',
        'parameters'  => function () {
          return $this -> getParameters("id");
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'message' => trans('api.deleted_successfully')
              ]
            ]
          ];
        }
      ]
    ];
  }

  public function products() {
    return [
      [
        'name'        => 'Products with offers search',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/search/offers',
        'method'      => 'GET',
        'description' => 'Search for products that have offers',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters('min_price?', 'max_price?', 'category?'),
            [
              [
                'name'       => 'sort',
                'type'       => 'GET',
                'validation' => 'optional|in:rating,-rating,time,-time'
              ]
            ]
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\ProductSearchResource::collection(
                    \App\Models\Product::with("averageRating") -> limit(10) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ], 
      [
        'name'        => 'Best selling products',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/search/best-seller',
        'method'      => 'GET',
        'description' => 'Get the best selling products',
        'parameters'  => function () {
          return [];
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\ProductSearchResource::collection(
                    \App\Models\Product::with("averageRating") -> limit(10) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ],[
        'name'        => 'Products Search',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/search',
        'method'      => 'GET',
        'description' => 'Search for products',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters('min_price?', 'max_price?', 'category?'),
            [
              [
                'name'       => 'sort',
                'type'       => 'GET',
                'validation' => 'optional|in:rating,-rating,time,-time'
              ]
            ]
          );
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  \App\Http\Resources\ProductSearchResource::collection(
                    \App\Models\Product::with("averageRating") -> limit(10) -> get()
                  ) -> toArray(request())
              ]
            ]
          ];
        }
      ], [
        'name'        => 'Get a Product',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/product/{id}',
        'method'      => 'GET',
        'description' => 'Get a specific product by id',
        'parameters'  => function () {
          return $this -> getParameters('id');
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => 
                  (new \App\Http\Resources\ProductResource(\App\Models\Product::first())) -> toArray(request())
              ]
            ]
          ];
        }
      ], [
          'name'        => 'Get a product\'s comments',
          'headers'     => self::DEFAULT_HEADERS(),
          'url'         => '/api/product/{id}/comments',
          'method'      => 'GET',
          'description' => 'Get the comments for a specific product by id',
          'parameters'  => function () {
            return $this -> getParameters('id');
          },
          'responses' => function () {
            return [
              [
                'code' => 200,
                'data' => [
                  'data' => 
                    \App\Http\Resources\RateResource::collection(\App\Models\Rate::paginate()) -> toArray(request())
                ]
              ]
            ];
          }
        ]
    ];
  }

  public function account() {
    return [
      [
        'name'        => 'Activate Phone',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/activate/phone',
        'method'      => 'POST',
        'description' => 'Activate phone number',
        'parameters'  => function () {
          return [
            [
              'name'       => 'code',
              'type'       => 'post',
              'validation' => 'required'
            ],
            [
              'name'       => 'phone',
              'type'       => 'post',
              'validation' => 'required[#]numbers_only'
            ]
          ];
        },
        'responses' => function () {
          return [
            [
              'code' => 200,
              'data' => [ 'message' => 'Activated successfully' ],
            ],
            [
              'code' => 403,
              'data' => [ 'message' => 'Invalid activation code' ],
            ]
          ];
        }
      ],
      [
        'name'        => 'Send phone Activation Code',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/phone/send',
        'method'      => 'POST',
        'description' => 'Send phone activation code SMS',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\RequestPhoneIdentityConfirmRequest());
        },
        'responses'=> function () {
          return [
            [
              'code' => 200,
              'data' => [ 'message' => trans("api.activation_code_sent") ],
            ],

            [
              'code' => 429,
              'data' => [ 'seconds_left' => 155 ],
            ]
          ];
        }
      ],
      [
        'name'        => 'Forget password',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/forget',
        'method'      => 'POST',
        'description' => 'Forget password (request password reset token)',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\ForgetPasswordRequest());
        },
        'responses'=> function () {
          return [
            [
              'code' => 200,
              'data' => [ 'token' => '23984923jr92jf923jf932jf932jf293f' ],
            ],

            [
              'code' => 403,
              'data' => [ 'error' => trans("api.invalid_code") ],
            ]
          ];
        }
      ],
      [
        'name'        => 'Reset password',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/forget/reset/{token}',
        'method'      => 'POST',
        'description' => 'Reset a forgotten password',
        'parameters'  => function () {
          return array_merge(
            $this -> getParameters("token"),
            $this -> postParameters(new \App\Http\Requests\Api\ResetPasswordRequest())
          );
        },
        'responses'=> function () {
          return [
            [
              'code' => 200,
              'data' => [ 'message' => trans("api.reset_successfully") ],
            ],

            [
              'code' => 403,
              'data' => [ 'error' => trans("api.invalid_token") ],
            ]
          ];
        }
      ],
      [
        'name'        => 'Change password',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/change-password',
        'method'      => 'POST',
        'description' => 'Change the logged in user\'s current password',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\ChangePasswordRequest());
        },
        'responses'=> function () {
          return [
            [
              'code' => 200,
              'data' => ["message" => trans("api.Password changed successfully")],
            ],

            [
              'code' => 401,
              'data' => ["error" => trans("api.invalid_old_password")],
            ]
          ];
        }
      ],
      [
        'name'        => 'Update profile',
        'headers'     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        'url'         => '/api/profile',
        'method'      => 'PUT',
        'description' => 'Update the profile for the logged in user',
        'parameters'  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\ProfileRequest());
        },
        'responses'=> function () {
          return [
            [
              'code' => 200,
              'data' => ["message" => trans("api.update_successfully")],
            ]
          ];
        }
      ]
    ];
  }

  public function utilities() {
    return [
      [
        'name'        => 'Get Countries',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/utilities/countries',
        'method'      => 'GET',
        'description' => 'Get Countries',
        'parameters'  => function () {
          return [];
        },
        'responses'   => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => \App\Http\Resources\CountryResource::collection(\App\Models\Country::all()) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Get Categories',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/utilities/categories',
        'method'      => 'GET',
        'description' => 'Get Categories',
        'parameters'  => function () {
          return [];
        },
        'responses'   => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => \App\Http\Resources\CategoryTreeResource::collection(\App\Models\Category::whereNull("parent_id") -> get()) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Get Services',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/utilities/services',
        'method'      => 'GET',
        'description' => 'Get All Services',
        'parameters'  => function () {
          return [];
        },
        'responses'   => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => \App\Http\Resources\ServiceResource::collection(\App\Models\Service::all()) -> toArray(request())
              ]
            ]
          ];
        }
      ],
      [
        'name'        => 'Get Payment Methods',
        'headers'     => self::DEFAULT_HEADERS(),
        'url'         => '/api/utilities/payment-methods',
        'method'      => 'GET',
        'description' => 'List all available payment-methods',
        'parameters'  => function () {
          return [];
        },
        'responses'   => function () {
          return [
            [
              'code' => 200,
              'data' => [
                'data' => \App\Http\Resources\PaymentResource::collection(\App\Models\Payment::all()) -> toArray(request())
              ]
            ]
          ];
        }
      ]
    ];
  }

  public function auth() {
    return [
      [
        "name"        => "Client Register",
        "headers"     => self::DEFAULT_HEADERS(),
        "url"         => "/api/register",
        "method"      => "post",
        "description" => "Register a client",
        "parameters"  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\RegisterRequest());
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
                "data"=>(new \App\Http\Resources\UserResource(\App\Models\User::first()))->toArray(request())],
            ]
          ];
        }
      ],
      [
        "name"        => "Client Login",
        "headers"     => self::DEFAULT_HEADERS(),
        "url"         => "/api/login",
        "method"      => "post",
        "description" => "Login a client",
        "parameters"  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\LoginRequest());
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
                "data"=>(new \App\Http\Resources\UserResource(\App\Models\User::first()))->toArray(request())],
            ]
          ];
        }
      ]
    ];
  }

  public function service_request() {
    return [
      [
        "name"        => "List existing service requests",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/service-request",
        "method"      => "get",
        "description" => "List service requests",
        "parameters"  => function () {
          return [];
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
                "data"=>\App\Http\Resources\ServiceRequestResource::collection(\App\Models\ServiceRequest::paginate())->toArray(request())],
            ]
          ];
        }
      ],
      [
        "name"        => "Create a new service request",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/service-request",
        "method"      => "post",
        "description" => "Create a new service request",
        "parameters"  => function () {
          return $this -> postParameters(new \App\Http\Requests\Api\ServiceRequestRequest());
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
                "data"=>(new \App\Http\Resources\ServiceRequestResource(\App\Models\ServiceRequest::first()))->toArray(request())],
            ]
          ];
        }
      ],
      [
        "name"        => "Show a specific service request by id",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/service-request/{id}",
        "method"      => "get",
        "description" => "Get a specific service request by id",
        "parameters"  => function () {
          return $this -> getParameters("id");
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
                "data"=>(new \App\Http\Resources\ServiceRequestResource(\App\Models\ServiceRequest::first()))->toArray(request())],
            ]
          ];
        }
      ],
      [
        "name"        => "Update an existing service request",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/service-request/{id}",
        "method"      => "put",
        "description" => "update an existing service request",
        "parameters"  => function () {
          return $this -> getParameters("id");
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
              "message" => trans("api.updated_successfully")
              ]
            ]
          ];
        }
      ],
      [
        "name"        => "Delete an existing service request",
        "headers"     => array_merge(self::DEFAULT_HEADERS(), self::AUTH_HEADERS()),
        "url"         => "/api/service-request/{id}",
        "method"      => "delete",
        "description" => "delete an existing service request",
        "parameters"  => function () {
          return $this -> getParameters("id");
        },
        "responses"   => function () {
          return [
            [
              "code" => 200,
              "data" => [
              "message" => trans("api.deleted_successfully")
              ]
            ]
          ];
        }
      ]
    ];
  }
}