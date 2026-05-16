import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/abstracts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::index
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:16
 * @route '/admin/abstracts'
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
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/abstracts/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
    const showForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
        showForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::show
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:46
 * @route '/admin/abstracts/{id}'
 */
        showForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::assignReviewer
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:96
 * @route '/admin/abstracts/{id}/assign-reviewer'
 */
export const assignReviewer = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: assignReviewer.url(args, options),
    method: 'post',
})

assignReviewer.definition = {
    methods: ["post"],
    url: '/admin/abstracts/{id}/assign-reviewer',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::assignReviewer
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:96
 * @route '/admin/abstracts/{id}/assign-reviewer'
 */
assignReviewer.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return assignReviewer.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::assignReviewer
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:96
 * @route '/admin/abstracts/{id}/assign-reviewer'
 */
assignReviewer.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: assignReviewer.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::assignReviewer
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:96
 * @route '/admin/abstracts/{id}/assign-reviewer'
 */
    const assignReviewerForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: assignReviewer.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::assignReviewer
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:96
 * @route '/admin/abstracts/{id}/assign-reviewer'
 */
        assignReviewerForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: assignReviewer.url(args, options),
            method: 'post',
        })
    
    assignReviewer.form = assignReviewerForm
/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::decide
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:122
 * @route '/admin/abstracts/{id}/decide'
 */
export const decide = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: decide.url(args, options),
    method: 'post',
})

decide.definition = {
    methods: ["post"],
    url: '/admin/abstracts/{id}/decide',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::decide
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:122
 * @route '/admin/abstracts/{id}/decide'
 */
decide.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return decide.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AbstractManagementController::decide
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:122
 * @route '/admin/abstracts/{id}/decide'
 */
decide.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: decide.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::decide
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:122
 * @route '/admin/abstracts/{id}/decide'
 */
    const decideForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: decide.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AbstractManagementController::decide
 * @see app/Http/Controllers/Admin/AbstractManagementController.php:122
 * @route '/admin/abstracts/{id}/decide'
 */
        decideForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: decide.url(args, options),
            method: 'post',
        })
    
    decide.form = decideForm
const AbstractManagementController = { index, show, assignReviewer, decide }

export default AbstractManagementController