<template>
    <div>
        <div>{{ iuser }}</div>
        <a id="custom-login-btn" @click="kakaoLogin">
            <img
                src="//k.kakaocdn.net/14/dn/btroDszwNrM/I6efHub1SN5KCJqLm1Ovx1/o.jpg"
                width="222"
                alt="카카오 로그인 버튼" >
        </a>
    </div>
</template>

<script>
export default {
    computed: {
        iuser() {
            return this.$store.state.iuser;
        }
    },
    methods: {
        kakaoLogin() {
            window.Kakao.Auth.login({
                scope: 'profile_nickname, profile_image, account_email', //받고 싶은거 적으면 됨
                success: this.getKakoAccount,
                fail: e => {
                    console.log(e);
                }
            });
        },
        getKakoAccount() {
            window.Kakao.API.request({
                url: '/v2/user/me',
                success: async res => {
                    const acc = res.kakao_account;
                    console.log(acc);
                    const params = {
                        social_type: 1,
                        email: acc.email,
                        nickname: acc.profile.nickname,
                        profile_img: acc.profile.profile_image_url,
                        thumb_img: acc.profile.thumbnail_image_url
                    }
                    console.log(params);
                    
                    const data = await this.$api('/user/signup', params);
                    console.log(data.result)

                    this.$store.commit('setIuser', data.result);

                },
                fail: e => {
                    console.log(e);
                }
            })
        }
    }
}
</script>

<style>

</style>
