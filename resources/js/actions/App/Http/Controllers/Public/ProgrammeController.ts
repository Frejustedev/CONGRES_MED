import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
const ProgrammeController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ProgrammeController.url(options),
    method: 'get',
})

ProgrammeController.definition = {
    methods: ["get","head"],
    url: '/programme',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
ProgrammeController.url = (options?: RouteQueryOptions) => {
    return ProgrammeController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
ProgrammeController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ProgrammeController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
ProgrammeController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ProgrammeController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
    const ProgrammeControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: ProgrammeController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
        ProgrammeControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ProgrammeController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ProgrammeController::__invoke
 * @see app/Http/Controllers/Public/ProgrammeController.php:70
 * @route '/programme'
 */
        ProgrammeControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ProgrammeController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    ProgrammeController.form = ProgrammeControllerForm
/**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
export const show = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/programme/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
show.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { slug: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    slug: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        slug: args.slug,
                }

    return show.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
show.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
show.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
    const showForm = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
        showForm.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ProgrammeController::show
 * @see app/Http/Controllers/Public/ProgrammeController.php:14
 * @route '/programme/{slug}'
 */
        showForm.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
ProgrammeController.show = show

export default ProgrammeController