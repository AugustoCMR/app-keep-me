<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Minha API",
 *     version="1.0.0",
 *     description="Documentação da API de Controle Financeiro",
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Autenticação via JWT. Use: Bearer {seu-token}"
 *  )
 */
class SwaggerController {}
