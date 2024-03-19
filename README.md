# WP Starter Blocks Theme

![GitHub license](https://img.shields.io/badge/license-Open%20Source-green)
![Node.js Version](https://img.shields.io/badge/node-%3E%3D20.xx-brightgreen)

Minimalist WordPress theme for creating custom ACF blocks. Designed for developers, this theme serves as a blank canvas for integrating Advanced Custom Fields (ACF) blocks into your WordPress projects. It's open-source and free for use.

## Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/hnikoloski/wp-starter-blocks your-theme-name
   ```
2. **Change directory**
   ```bash
   cd your-theme-name
   ```
3. **Install dependencies**

   Ensure you have Node.js version 20.xx or higher installed. If you don't have pnpm, [install it here](https://pnpm.io/installation).

   ```bash
   pnpm install
   ```

## Development & Build Commands

- **Watch Files**: `pnpm run watch`
- **Development Build**: `pnpm run build:dev`
- **Production Build**: `pnpm run build:prod`
- **Clean Dist Folder**: `pnpm clean`
- **Production (Clean & Build)**: `pnpm run prod`

## Extra Information

Check out `inc/acf/acf_blocks.php` for an example of how blocks are set up. Assets are enqueued only when a block is used, so write block-specific JS or SCSS under `src/block-assets` and global assets just under `/src`.

## License

This project is open-source and free for use. It is intended to be a community-driven project where contributions, improvements, and suggestions are welcome.
