<template>
  <div class="random-ruller">
    <template v-if="participants.length">
      <div class="random-ruller__code-block">
        <span
          v-if="participantCurrent"
          :class="['random-ruller__code', { 'random-ruller__code-prewinner': preWinner }]"
          v-html="participantCurrent.code"
        />
      </div>

      <div class="random-ruller__progress">
        <transition name="fade">
          <div v-show="progress" class="progress">
            <div class="progress-bar" :style="{'width':`${progress}%`}"></div>
          </div>
        </transition>
      </div>
    </template>
    <div class="h5 mt-5 mb-4 text-center" v-else>
      <span v-if="globalLoading">Загрузка участников...</span>
      <span v-else>Не найдено участников</span>
    </div>

    <div class="d-flex justify-content-center">
      <template v-if="preWinner" >
        <Btn
          class="mx-3"
          color="success"
          size="lg"
          @click="setWinner"
        >Подтвердить</Btn>
        <Btn
          class="mx-3"
          color="secondary"
          size="lg"
          @click="clearPreWinner"
        >Отменить</Btn>
      </template>
      <Btn
        v-else
        color="info"
        size="lg"
        :disabled="disableBtnRun"
        @click="start"
      >Крутить</Btn>
    </div>

    <div v-show="isWinners" class="random-ruller__winners">
      <ul class="list-group mt-4">
        <li
          v-for="number in Object.keys(winners)"
          :key="number"
          class="list-group-item"
        >{{ winners[number].code }}</li>
      </ul>
    </div>
    <div class="text-center my-5">
      <Btn
        color="secondary"
        @click="final"
      >Завершить</Btn>
    </div>
  </div>
</template>

<script>
import Btn from '@/components/ui/Btn'

export default {
	name: 'RandomRuller',

  components: {
    Btn,
  },

  props: {
    participants: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      randInd: null,
      preWinner: null,
      counterWinners: 0,
      winners: {},
      randomizer: {
        _speed: 100,
        duration: 0,
        intervalFunc: null,
        progress: 0,
        prevRand: 0,
        run (opt, func, callback)
        {
          const prtcpsAmount = opt.max
          this.duration = this.calcDuration(prtcpsAmount)

          const time = new Date().getTime() + this.duration
          this.intervalFunc = setInterval(() =>
          {
            const now = new Date().getTime()
            const randInt = this.randomInt(prtcpsAmount)
            this.progress = (time - now) / this.duration * 100
            func(randInt)
          }, this._speed)

          setTimeout(() =>
          {
            clearInterval(this.intervalFunc)
            this.time = null
            this.intervalFunc = null
            this.progress = 0
            callback()
          }, this.duration)
        },
        /* рассчёт времени ротации */
        calcDuration (countParticipants)
        {
          const _durationMin = 1000
          const _durationMax = 15000
          const _prtcpsMax = 1000 /* только для рассчёта как 100% */
          const percOfprtcps = Math.min(countParticipants, _prtcpsMax) / _prtcpsMax * 100
          const durationPlus = (_durationMax - _durationMin) * percOfprtcps / 100

          return (_durationMin + durationPlus)
        },
        randomInt (countParticipants)
        {
          const _getRand = () => Math.floor(Math.random() * countParticipants)
          let result = _getRand()

          if (countParticipants > 1 && this.prevRand === result)
          {
            while (this.prevRand === result) {
              result = _getRand()
            }
          }
          this.prevRand = result

          return result
        }
      },
    }
  },

  computed: {
    participantCurrent ()
    {
      return this.participants[this.randInd]
    },
    globalLoading ()
    {
      return !!this.$store.getters['variables/loading']
    },
    progress ()
    {
      return this.randomizer.progress
    },
    isWinners ()
    {
      return Object.keys(this.winners).length
    },
    disableBtnRun ()
    {
      return !(this.participants.length) || !!this.progress
    },
  },

  methods: {
    start ()
    {
      const options = {
        max: this.participants.length,
      }
      this.randomizer.run(options, (rand) =>
      {
        this.randInd = rand
      },
      () => {
        this.preWinner = this.participantCurrent
      })
    },

    clearPreWinner ()
    {
      this.preWinner = null
      this.randInd = null
    },

    setWinner ()
    {
      const winner = this.preWinner
      this.counterWinners++
      this.winners[this.counterWinners] = winner

      this.$emit('setWinner', winner.id)
      this.clearPreWinner()
    },

    final ()
    {
      this.$emit('final')
    },
  },
}
</script>

<style scoped lang="scss" src="./style.scss"></style>
