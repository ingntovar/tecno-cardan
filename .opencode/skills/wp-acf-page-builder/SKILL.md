---
name: wp-acf-page-builder
description: >
  Documenta como trabajar con el page builder basado en ACF del theme La Fonda,
  incluyendo render, lectura de fields, normalizacion y extension de layouts.
  Trigger: cuando un agente necesite editar o extender el builder, ACF de paginas,
  normalizers o componentes renderizados desde pages/page-builder.php.
license: Apache-2.0
metadata:
  author: gentleman-programming
  version: "1.0"
---

# La Fonda ACF Page Builder

## When to Use

- Cuando toques `includes/components/page-builder/`.
- Cuando agregues o cambies layouts del flexible content `components` en ACF.
- Cuando necesites entender como una pagina normal termina renderizando componentes desde `pages/page-builder.php`.
- Cuando trabajes con `heading`, `copy`, `include_page_data` o cualquier dato de contexto de pagina.

## Critical Patterns

### ACF is the data source, not the architecture

- No trates ACF como la ubicacion arquitectonica del builder.
- El builder vive en `includes/components/page-builder/`, no como un `home-builder` dentro de ACF.
- ACF define y entrega datos; la logica de composicion, normalizacion y render vive en PHP del theme.

### Component field-group ownership

- Cuando crees un component asociado a un grupo de campos ACF, mantenelo granular en su propio Field Group JSON dedicado con `active: false`.
- Nunca agregues los campos del component inline dentro del Page Builder.
- El Page Builder debe consumir components nuevos mediante campos/layouts clonados desde ese Field Group; solo usa campos inline si el usuario lo solicita explicitamente.

### Render flow

1. `front-page.php` y `page.php` enrutan paginas hacia `tc_assemble_template('page-builder')`; `index.php` conserva el fallback general de WordPress por separado.
2. `tc_assemble_template()` carga el header, renderiza una vez el navbar global canonico desde `pages/components/navbar.php`, envuelve la vista solicitada en `<main>` y carga el footer.
3. `pages/page-builder.php` obtiene el `post_id` actual y llama `tc_get_page_builder_sections($page_id)`.
4. `tc_get_page_builder_sections()` lee el flexible content `components`, arma `page_context` y normaliza cada layout.
5. Cada normalizer devuelve una seccion con esta forma:

```php
array(
    'component' => 'hero',
    'args' => array(...),
)
```

6. `pages/page-builder.php` recorre las secciones y llama `tc_render_component($section['component'], $section['args'])`; si no hay secciones validas, consume el loop una vez y renderiza `the_content()`.
7. `tc_render_component()` incluye `pages/components/{component}.php`, donde solo debe existir markup presentacional y defaults ligeros.

### Folder architecture

```text
includes/
  acf/
    json-sync/                # Definicion de field groups, solo como fuente de datos
  components/
    page-builder/
      builder.php            # Entrada principal: obtiene sections y page context
      index.php              # Barrel del builder
      normalizer/
        index.php            # Barrel de normalizers
        component.php        # Router por acf_fc_layout
        *.php                # Normalizers por responsabilidad
pages/
  page-builder.php           # Consume el builder o renderiza the_content()
  components/
    *.php                    # Presentational components
```

### Read fields in the right layer

- Lee `get_field()` en el builder o en helpers de normalizacion, no dentro de `pages/components/*.php`.
- Usa `tc_get_page_builder_sections()` como frontera entre datos ACF y UI renderizada.
- `pages/components/*.php` debe recibir datos ya listos para pintar via `$args`.
- Si un component necesita estructura extra, agrega esa transformacion en un normalizer, no en el template.
- Mantene chequeos defensivos como `function_exists('get_field')`, `is_array()` y `empty()` en la capa de builder/normalizer.

### Field access examples

```php
$components = get_field('components', $post_id);

$page_context = array(
    'include_page_data' => (bool) get_field('include_page_data', $post_id),
    'heading' => trim((string) get_field('heading', $post_id)),
    'copy' => trim((string) get_field('copy', $post_id)),
);
```

- Usa siempre `post_id` explicito cuando leas fields del builder.
- Preferi normalizar strings y booleans al momento de lectura, no dentro del template.
- Si el flexible content devuelve wrappers clonados como `hero` o `filosofos`, resuelvelos en el normalizer con fallback al componente raiz.

### Page context conventions

- El contexto de pagina comun vive en `tc_get_page_builder_context($post_id)`.
- Hoy el contexto incluye:
  - `include_page_data`
  - `heading`
  - `copy`
- Si un layout necesita reutilizar datos globales de la pagina, agregalos primero al `page_context`.
- Un layout decide si consume ese contexto; ejemplo: `hero` usa `include_page_data` para completar `heading` y `copy` cuando el layout no trae valores propios.

### Normalizer responsibilities

- Un normalizer transforma la forma cruda de ACF en props limpias para un componente.
- Cada normalizer debe encargarse de una responsabilidad concreta: seccion hero, card de post, media, card de filosofo, etc.
- Si dos layouts comparten transformaciones, extrae helpers pequenos reutilizables dentro de `normalizer/`.
- Mantene `normalizer/index.php` como barrel file y registra ahi cualquier nuevo archivo.
- Mantene `normalizer/component.php` como mapa explicito de `acf_fc_layout` -> normalizer.

### Components are presentational

- `pages/components/*.php` renderiza HTML usando variables ya normalizadas.
- Los components pueden tener defaults simples para evitar markup roto.
- No metas llamadas nuevas a ACF, queries complejas ni branching de arquitectura en estos archivos.
- Un component puede incluir otros components con `lff_include_component()`, pero la orquestacion del builder ocurre antes.

## Current Builder Map

| ACF layout (`acf_fc_layout`) | Normalizer                             | Rendered component                  |
| ---------------------------- | -------------------------------------- | ----------------------------------- |
| `hero`                       | `lff_normalize_hero_section()`         | `pages/components/hero.php`         |
| `filosofos`                  | `lff_normalize_philosophers_section()` | `pages/components/philosophers.php` |

## Add a New Layout Without Spaghetti

1. Crea el Field Group JSON dedicado del component con `active: false`; no agregues sus campos inline al Page Builder.
2. Expone el component en el flexible content `components` mediante un campo/layout clonado desde ese Field Group. Solo usa campos inline si el usuario lo solicita explicitamente.
3. Crea un normalizer nuevo en `includes/components/page-builder/normalizer/`.
4. Registra el archivo en `includes/components/page-builder/normalizer/index.php`.
5. Mapea el nuevo `acf_fc_layout` en `includes/components/page-builder/normalizer/component.php`.
6. Devuelve una estructura estable con `component` y `args`.
7. Crea o reutiliza un template presentacional en `pages/components/`.
8. Si necesitas media/cards compartidas, reutiliza helpers existentes en vez de duplicar logica.

### Minimal example

```php
// includes/components/page-builder/normalizer/quote-section.php
function lff_normalize_quote_section($component) {
    $quote = trim((string) ($component['quote'] ?? ''));
    $author = trim((string) ($component['author'] ?? ''));

    if ($quote === '') {
        return array();
    }

    return array(
        'component' => 'quote-section',
        'args' => array(
            'quote' => $quote,
            'author' => $author,
        ),
    );
}
```

```php
// includes/components/page-builder/normalizer/component.php
if ($layout === 'quote') {
    return lff_normalize_quote_section($component);
}
```

```php
// pages/components/quote-section.php
<section>
    <blockquote><?php echo esc_html($quote); ?></blockquote>
    <?php if (! empty($author)) : ?>
        <cite><?php echo esc_html($author); ?></cite>
    <?php endif; ?>
</section>
```

## Guardrails

- No mezcles `get_field()` directo en `pages/page-builder.php` o en `pages/components/` salvo casos excepcionales ya existentes y justificados.
- No metas logica de layout nueva directo en `pages/page-builder.php`; ahi solo se consume la salida del builder o el fallback de contenido.
- No conviertas `component.php` en un switch gigante con logica embebida; solo debe enrutar a normalizers dedicados.
- No dupliques estructuras de cards/media si ya existe un normalizer de apoyo.
- Si un layout empieza a crecer, separa subnormalizers por responsabilidad antes de tocar el template.

## Key Files

- `functions.php` - carga ACF sync y el page builder.
- `includes/components/page-builder/builder.php` - obtiene `components` y `page_context`.
- `includes/components/page-builder/normalizer/component.php` - resuelve el layout actual.
- `includes/components/page-builder/normalizer/index.php` - barrel de normalizers.
- `pages/page-builder.php` - integra builder + fallback de contenido + render.
- `includes/utils.php` - `tc_render_component()` conecta nombres de component con `pages/components/`.
- `includes/acf/json-sync/group_69c7f716b76a7.json` - group actual del flexible content `components`.

## Commands

```bash
php -l "includes/components/page-builder/builder.php"
php -l "includes/components/page-builder/normalizer/component.php"
php -l "pages/page-builder.php"
```
