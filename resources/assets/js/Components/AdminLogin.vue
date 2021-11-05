<template>
    <div class="row login-form">
        <div class="col-md-6 offset-3 pt-md-5">
            <div class="card border-radius-0">
                <div class="card-header bg-gradient-success">
                    <h2 style="margin-top: 0">{{_trans('label.shared.Sign in')}}</h2>
                </div>
                <div class="card-body px-4">
                    <form method="POST" action="https://app.getmaple.ca/login">
                        <div class="form-group refreshed">
                            <label for="email">{{_trans('label.user.email')}}</label>
                            <input data-e2e="email" id="email" type="email" name="email" value=""
                                   placeholder="youremail@example.com" class="form-control refreshed"
                                   autocomplete="email"
                                   required="">
                        </div>
                        <div class="form-group relative refreshed" style="margin-bottom: 30px">
                            <label for="password">{{_trans('label.user.password')}}</label>
                            <input data-e2e="password" type="password" name="password" id="password"
                                   class="form-control refreshed" autocomplete="current-password" required="">
                        </div>
                        <div class="form-group refreshed">
                            <button data-heap="login-submit-button" data-e2e="login_submit_button" type="submit"
                                    class="btn btn-primary btn-lg btn-block refreshed">
                                {{_trans('label.shared.Sign in')}}
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember" class="checkbox-inline">
                                        {{_trans('label.shared.Remember me')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EmptyLayout from "@layouts/EmptyLayout";
    import { defineComponent } from 'vue'

    export default defineComponent({
        name: "admin-login",
        layout: EmptyLayout,

    })
</script>

<style scoped>
    .login-form {
        background-color: #f7f7f7 !important;
        height: 100vh;
        margin: 0 !important;
    }

</style>
