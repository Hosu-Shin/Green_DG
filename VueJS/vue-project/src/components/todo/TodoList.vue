<template>
    <section>
        <transition-group name="list" tag="ul">
            <li :key="todoItem.itodo" v-for="(todoItem) in propsItems" class="shadow">
                <i class="checkBtn fas fa-check" aria-hidden="true"></i>
                <div class="grow_1 d-flex flex-col justify_content_evenly">
                    <div class="ctnt">{{ todoItem.todo }}</div>
                    <div class="small_text">{{ todoItem.created_at }}</div>
                </div>
                <span class="removeBtn" type="button" @click="removeTodo(todoItem.itodo)">
                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                </span>
            </li>
        </transition-group>
    </section>
</template>


<script>
export default {
    props: { propsItems : Array },
    // props: [ 'todoItems'],
    methods: {
        // removeTodo(todoItem, index) {
        //     // localStorage.removeItem(todoItems, index);
        //     // this.todoItems.splice(index, 1);
        //     // console.log(todoItems + ", " + index);
        //     this.$emit('childRemoveTodo', todoItem, index);

        // }
        removeTodo(key) {
            this.$emit('childRemoveTodo', key);
        }
    },
}
</script>

<style scoped>
    .list-enter-active, .list-leave-active { transition: all 1s;}
    .list-enter-from, .list-leave-to { opacity: 0; transform: translateY(30px);}
    /* .list-enter, .list-leave-to { opacity: 0; transform: translateY(30px); } */

    ul { list-style-type: none; padding-left: 0; margin-top: 0; text-align: left; }
    li { display: flex; margin: 0.5rem 0; padding: 5px 0.9rem; background-color: white; border-radius: 5px; 
        /* min-height: 50px; height: 50px; line-height: 50px; */ }
    .checkBtn { line-height: 50px; color: #62acde; margin-right: 20px; }
    .removeBtn { line-height: 50px; margin-left: auto; color: #de4343; }
    .small_text { font-size: .8rem; color: #828181; } 
</style>

