<template>
  <div class="sidebar border-right">
    <div class="list-group list-group-flush">
      <a 
        href="javascript:void(0)" 
        class="list-group-item sidebar-list__item"
        v-for="(item, index) in list"
        :key="index"
      >{{ item }}</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      list: [
        '1 Введение',
        '2 Цель и задачи работы',
        '3 Задание',
        '4 Общие сведения',
        '5 Краткие теоретические сведения о модуле TDM',
        '6 Создание и редактирование объектов маршрута. Параметры объектов',
        '7 Добавление графической информации и формирование документации',
        '8 Выполнение практической части',
        '9 Контрольные вопросы',
      ]
    }
  }
};
</script>

<style lang="scss">
.sidebar {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  overflow: auto;
}

.sidebar-list__item {
  transition: all .2s;
  color: #343a40;
}

.sidebar-list__item:hover {
  background-color: #343a40;
  color: #ffffff !important;
  text-decoration: none;
}
</style>
