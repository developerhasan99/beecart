#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# Define variables
PLUGIN_SLUG="beecart"
# Extract version from main plugin file
VERSION=$(grep -m 1 "Version: " beecart.php | grep -o "[0-9.]*")
EXPORT_DIR="export"
ARCHIVE_NAME="${PLUGIN_SLUG}-${VERSION}.zip"

echo "==================================================="
echo "🐝 Building production build for ${PLUGIN_SLUG} v${VERSION}..."
echo "==================================================="

# Rebuild tailwind css for production (minified)
echo "📦 Running frontend build..."
npm run build
echo "✅ Build complete."

# Ensure we have a clean build directory
echo "🧹 Cleaning up previous exports..."
rm -rf ${EXPORT_DIR}
mkdir -p ${EXPORT_DIR}/${PLUGIN_SLUG}

# Copy necessary files to export directory
echo "📂 Copying files to export directory (ignoring configs/dev files)..."
# We use rsync. Fallback to cp if rsync is unavailable, but Mac has rsync.
rsync -rc --exclude-from='.exportignore' ./ ${EXPORT_DIR}/${PLUGIN_SLUG}/

# Zip the plugin
echo "🗜️ Zipping the plugin..."
cd ${EXPORT_DIR}
zip -rq ${ARCHIVE_NAME} ${PLUGIN_SLUG}
cd ..

echo "==================================================="
echo "🎉 Export complete! Your production file is located at:"
echo "📁 ${EXPORT_DIR}/${ARCHIVE_NAME}"
echo "==================================================="
