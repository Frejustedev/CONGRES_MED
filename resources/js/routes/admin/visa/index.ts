import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/visa-letters',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\VisaLetterController::index
 * @see app/Http/Controllers/Admin/VisaLetterController.php:15
 * @route '/admin/visa-letters'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Admin\VisaLetterController::generate
 * @see app/Http/Controllers/Admin/VisaLetterController.php:40
 * @route '/admin/visa-letters/{id}/generate'
 */
export const generate = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

generate.definition = {
    methods: ["post"],
    url: '/admin/visa-letters/{id}/generate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\VisaLetterController::generate
 * @see app/Http/Controllers/Admin/VisaLetterController.php:40
 * @route '/admin/visa-letters/{id}/generate'
 */
generate.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return generate.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\VisaLetterController::generate
 * @see app/Http/Controllers/Admin/VisaLetterController.php:40
 * @route '/admin/visa-letters/{id}/generate'
 */
generate.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: generate.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\VisaLetterController::generate
 * @see app/Http/Controllers/Admin/VisaLetterController.php:40
 * @route '/admin/visa-letters/{id}/generate'
 */
    const generateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: generate.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\VisaLetterController::generate
 * @see app/Http/Controllers/Admin/VisaLetterController.php:40
 * @route '/admin/visa-letters/{id}/generate'
 */
        generateForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: generate.url(args, options),
            method: 'post',
        })
    
    generate.form = generateForm
const visa = {
    index: Object.assign(index, index),
generate: Object.assign(generate, generate),
}

export default visa