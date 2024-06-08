<?php

namespace App\Virtual;

use OpenApi\Attributes as OAT;

$panel_enums = [];

$panel_enums = array_unique($panel_enums);

(defined("PANEL_ENUMS")) ?: define("PANEL_ENUMS", $panel_enums);
(defined("BASE_URL")) ?: define("BASE_URL", config('app.url'));

#[OAT\Info(
    version: "0.1",
    title: "API Documentation",
    termsOfService: "",
    contact: new OAT\Contact(name: "", email: ""),
    license: new OAT\License(name: "MIT License", url: "https://opensource.org/license/mit",),
)]

#[OAT\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Enter JWT Token",
    name: "bearerAuth",
    in: "header",
    scheme: "bearer"
)]

class ApiDocsController {}
