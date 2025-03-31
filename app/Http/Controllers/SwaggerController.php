<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="CoreLab API Todo-List",
 *      description="Documentação para a CoreLab REST API",
 *      @OA\Contact(
 *          email="guilhermedelmiro11@gmail.com"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer"
 * )
 *
 * @OA\Schema(
 *      schema="Task",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="title", type="string", example="Documentação completa do projeto tal..."),
 *      @OA\Property(property="description", type="string", example="Escrever documentação abrangente para projeto tal..."),
 *      @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="pending"),
 *      @OA\Property(property="status_label", type="string", example="Pendente"),
 *      @OA\Property(
 *          property="color",
 *          type="object",
 *          @OA\Property(property="id", type="integer", example=3, description="ID da cor"),
 *          @OA\Property(property="name", type="string", example="Azul", description="Nome da cor"),
 *          @OA\Property(property="hex_code", type="string", example="#0000FF", description="Cor em formato hexadecimal")
 *      ),
 *      @OA\Property(property="due_date", type="string", format="date", example="2025-12-31"),
 *      @OA\Property(property="is_overdue", type="boolean", example=false),
 *      @OA\Property(property="is_favorited", type="boolean", example=false),
 *      @OA\Property(property="favorites_count", type="integer", example=1),
 *      @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01 12:00:00"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-02 13:00:00"),
 *      @OA\Property(
 *          property="user",
 *          type="object",
 *          @OA\Property(property="id", type="integer", example=3, description="ID do usuário"),
 *          @OA\Property(property="name", type="string", example="João Silva", description="Nome do usuário"),
 *          @OA\Property(
 *              property="profile",
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1, description="ID do perfil"),
 *              @OA\Property(property="type", type="string", enum={"admin", "manager", "member"}, example="admin", description="Tipo do perfil"),
 *              @OA\Property(property="description", type="string", example="Administrador", description="Descrição do perfil")
 *          )
 *      )
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1, description="ID do usuário"),
 *     @OA\Property(property="name", type="string", example="João Silva", description="Nome de usuário"),
 *     @OA\Property(property="email", type="string", format="email", example="joao@email.com", description="Email de usuário"),
 *     @OA\Property(
 *         property="profile",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=3, description="ID do perfil"),
 *         @OA\Property(property="type", type="string", enum={"admin", "manager", "member"}, example="member", description="Tipo de perfil de usuário")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01 12:00:00", description="Data da criação"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-02 13:00:00", description="Última data de atualização")
 * )
 *
 * @OA\Schema(
 *      schema="Error",
 *      @OA\Property(property="message", type="string", example="Mensagem de erro"),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          @OA\Property(
 *              property="field",
 *              type="array",
 *              @OA\Items(type="string", example="O campo é necessário")
 *          )
 *      )
 * )
 *
 * @OA\Schema(
 *     schema="TaskColor",
 *     title="taskColor",
 *     description="Modelo de cores",
 *     @OA\Property(property="id", type="integer", format="int64", example=1, description="ID da cor"),
 *     @OA\Property(property="name", type="string", example="Azul", description="Nome da cor"),
 *     @OA\Property(property="hex_code", type="string", example="#0000FF", description="Código hexadecimal da cor")
 * )
 */
class SwaggerController extends Controller
{
    //
}
