export default {
  content: [
    './index.html',
    './*.html',
    './components/**/*.html',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'klein-blue': '#3872B8',
        'may-green': '#5E9340',
        'bright-cerulean': '#2EAAE1',
        'light-green': '#8DB25F',
        'mustard': '#FFDE59',
        'off-white': '#F8F9F6',
        'warm-grey': '#E5E7E2',
        'charcoal': '#2A2D2B',
        'soft-grey': '#6B6E6A',
        'footer-navy': '#1F3A52',
      },
      fontFamily: {
        display: ['Manrope', 'system-ui', 'sans-serif'],
        body: ['"PT Sans"', 'Helvetica', 'Arial', 'sans-serif'],
        accent: ['"Rage Italic"', 'cursive'],
      },
      fontSize: {
        'display-1': ['80px', { lineHeight: '1.1', letterSpacing: '-0.02em', fontWeight: '800' }],
        'display-1-mobile': ['40px', { lineHeight: '1.1', letterSpacing: '-0.01em', fontWeight: '800' }],
        'display-2': ['48px', { lineHeight: '1.2', fontWeight: '700' }],
        'display-2-mobile': ['32px', { lineHeight: '1.2', fontWeight: '700' }],
        'h3': ['32px', { lineHeight: '1.3', fontWeight: '700' }],
        'h3-mobile': ['24px', { lineHeight: '1.3', fontWeight: '700' }],
        'body-lg': ['20px', { lineHeight: '1.6' }],
        'body-lg-mobile': ['18px', { lineHeight: '1.6' }],
        'body-md': ['17px', { lineHeight: '1.65' }],
        'body-md-mobile': ['16px', { lineHeight: '1.65' }],
        'eyebrow': ['14px', { lineHeight: '1.2', letterSpacing: '0.1em', fontWeight: '700' }],
      },
      spacing: {
        'section': '120px',
        'section-mobile': '64px',
      },
      borderRadius: {
        'sm': '4px',
        'md': '8px',
        'lg': '16px',
        'xl': '24px',
      },
      boxShadow: {
        'card': '0 4px 24px rgba(56, 114, 184, 0.06)',
        'card-hover': '0 8px 32px rgba(56, 114, 184, 0.12)',
        'modal': '0 16px 48px rgba(0, 0, 0, 0.16)',
      },
      backgroundImage: {
        'gradient-water': 'linear-gradient(135deg, #3872B8 0%, #2EAAE1 100%)',
        'gradient-nature': 'linear-gradient(135deg, #5E9340 0%, #8DB25F 100%)',
      },
      zIndex: {
        'dropdown': '10',
        'sticky': '20',
        'header': '30',
        'backdrop': '40',
        'modal': '50',
        'toast': '60',
      },
      maxWidth: {
        'container': '1280px',
        'prose-narrow': '720px',
      },
      screens: {
        'xs': '360px',
      },
    },
  },
  plugins: [],
};
