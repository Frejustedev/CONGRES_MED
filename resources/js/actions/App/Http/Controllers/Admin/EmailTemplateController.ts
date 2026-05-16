import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/email-templates',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::index
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:14
 * @route '/admin/email-templates'
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
* @see \App\Http\Controllers\Admin\EmailTemplateController::store
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:42
 * @route '/admin/email-templates'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/email-templates',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::store
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:42
 * @route '/admin/email-templates'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::store
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:42
 * @route '/admin/email-templates'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::store
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:42
 * @route '/admin/email-templates'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::store
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:42
 * @route '/admin/email-templates'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/email-templates/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
edit.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
    const editForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
        editForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::edit
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:33
 * @route '/admin/email-templates/{id}/edit'
 */
        editForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::update
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:49
 * @route '/admin/email-templates/{id}'
 */
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/email-templates/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::update
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:49
 * @route '/admin/email-templates/{id}'
 */
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\EmailTemplateController::update
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:49
 * @route '/admin/email-templates/{id}'
 */
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::update
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:49
 * @route '/admin/email-templates/{id}'
 */
    const updateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\EmailTemplateController::update
 * @see app/Http/Controllers/Admin/EmailTemplateController.php:49
 * @route '/admin/email-templates/{id}'
 */
        updateForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
const EmailTemplateController = { index, store, edit, update }

export default EmailTemplateController