import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/groups',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::index
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:19
 * @route '/admin/groups'
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
* @see \App\Http\Controllers\Admin\GroupRegistrationController::store
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:27
 * @route '/admin/groups'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/groups',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::store
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:27
 * @route '/admin/groups'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::store
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:27
 * @route '/admin/groups'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::store
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:27
 * @route '/admin/groups'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\GroupRegistrationController::store
 * @see app/Http/Controllers/Admin/GroupRegistrationController.php:27
 * @route '/admin/groups'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const groups = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
}

export default groups